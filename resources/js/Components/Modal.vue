<script>
import { ref, toRef } from "vue";
import axios from "axios";
import Step from "../Components/Step.vue";

const updateTitle = async (title, id) => {
  const data = await axios.put(`${import.meta.env.VITE_APP_URL}/api/jhas/${id}`, {
    title,
  });
  return data;
};

const updateAuthor = async (author, id) => {
  const data = await axios.put(`${import.meta.env.VITE_APP_URL}/api/jhas/${id}`, {
    author,
  });
  return data;
};

const postStep = async (id) => {
  const toSend = {
    jha_id: id,
    title: "New Step",
  };

  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/steps`, toSend);

  return data;
};

export default {
  name: "Modal",
  components: {
    Step,
  },
  // setup(props) {
  //   const listedSteps = ref(props.steps);

  //   const addStep = () => {
  //     postStep(props.id)
  //     .then(data => {
  //       listedSteps.value = listedSteps.value.concat(data)
  //     })
  //   }

  //   return { addStep };
  // },
  methods: {
    close() {
      this.$emit("close");
      this.newAuthor = false;
      this.newTitle = false;
      this.editable = false;
    },
    handleDelete(id) {
      this.editable = false;
      this.$emit("deleteJha", id);
      this.$emit("close");
    },
    enableEdit() {
      this.editable = true;
    },
    disableEdit(id) {
      this.editable = false;
      this.$emit("updateModal", id);
    },
    editTitle() {
      this.titleEditable = true;
    },
    disableTitle() {
      this.titleEditable = false;
    },
    submitTitle(id) {
      updateTitle(this.$refs.form$.data.title, id).then((res) => {
        this.newTitle = res.data.title;
        this.titleEditable = false;
      });
    },
    editAuthor() {
      this.authorEditable = true;
    },
    disableAuthor() {
      this.authorEditable = false;
    },
    submitAuthor(id) {
      updateAuthor(this.$refs.form$.data.author, id).then((res) => {
        this.newAuthor = res.data.author;
        this.authorEditable = false;
      });
    },
    addStep(){
      postStep(this.id)
      .then(data => {
        this.mutableSteps = this.mutableSteps.concat(data)
      })
    },
    updateModal() {
      this.$emit("updateModal", this.id);
      this.mutableSteps = [];
    },
  },
  props: {
    id: Number,
    title: { type: String, default: "Title" },
    author: { type: String, default: "Author" },
    description: { type: String, default: null },
    created_at: { type: String, default: null },
    updated_at: { type: String, default: null },
    steps: { type: Array, default: [] },
  },
  data() {
    return {
      editable: false,
      titleEditable: false,
      authorEditable: false,
      newTitle: false,
      newAuthor: false,
      mutableSteps: [],
    };
  },
  computed: {
    listedSteps(){
      return this.steps.concat(this.mutableSteps)
    }
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-5/6 h-5/6">
      <header class="p-[15px] flex flex-col relative border-b-2 justify-between">
        <slot name="header">
          <div class="flex flex-row">
            <div class="text-3xl font-bold" v-if="!titleEditable">
              {{ this.newTitle ? this.newTitle : title }}
            </div>
            <div v-else>
              <Vueform ref="form$" :endpoint="false" @submit="() => submitTitle(id)">
                <TextElement name="title" placeholder="Title" rules="required" />
              <ButtonElement class="invisible" name="submit" submits>
              </ButtonElement>
              </Vueform>
            </div>
            <div v-if="editable && !titleEditable">
              <img
                src="/images/edit.png"
                class="size-3 cursor-pointer"
                @click="editTitle"
              />
            </div>
            <div
              id="accept-close-buttons"
              class="flex flex-col justify-between pl-1"
              v-if="titleEditable"
            >
              <div>
                <img
                  src="/images/accept.png"
                  class="size-4 cursor-pointer"
                  @click="() => submitTitle(id)"
                />
              </div>
              <div>
                <img
                  src="/images/delete-button.png"
                  class="size-4 cursor-pointer"
                  @click="disableTitle"
                />
              </div>
            </div>
          </div>
          <div class="flex flex-row">
            <div class="text-md" v-if="!authorEditable">
              Created by {{ this.newAuthor ? this.newAuthor : author }}
            </div>
            <div v-else>
              <Vueform ref="form$" :endpoint="false" @submit="() => submitAuthor(id)">
                <TextElement name="author" placeholder="Author" rules="required" />
              <ButtonElement class="invisible" name="submit" submits>
              </ButtonElement>
              </Vueform>
          Create JHA Form
            </div>
            <div>
              <div v-if="editable && !authorEditable">
                <img
                  src="/images/edit.png"
                  class="size-3 ml-1 cursor-pointer"
                  @click="editAuthor"
                />
              </div>
              <div
                id="accept-close-buttons"
                class="flex flex-col justify-between pl-1"
                v-if="authorEditable"
              >
                <div>
                  <img
                    src="/images/accept.png"
                    class="size-4 cursor-pointer"
                    @click="() => submitAuthor(id)"
                  />
                </div>
                <div>
                  <img
                    src="/images/delete-button.png"
                    class="size-4 cursor-pointer"
                    @click="disableAuthor"
                  />
                </div>
              </div>
            </div>
          </div>
        </slot>
        <button
          type="button"
          class="absolute top-0 right-0 text-xl font-bold p-2.5 bg-transparent text-red-500 cursor-pointer"
          @click="close"
        >
          x
        </button>
      </header>
      <section class="relative px-5 py-2.5">
        <slot name="body">
          <div class="grid grid-cols-3 border-b-2">
            <div>Steps</div>
            <div>Hazards</div>
            <div>Controls</div>
          </div>
          <div v-for="(step, index) in listedSteps">
            <div class="border-b-2 border-x-2">
              <Step
                :key="step.id"
                :num="index"
                :editable="editable"
                v-bind="step"
                @updateModal="updateModal"
              />
            </div>
          </div>
          <div v-if="editable" class="w-full flex flex-row justify-start">
            <div
          @click="addStep"
          class="bg-green-500 p-1 rounded-xl text-center text-sm border-2 w-2/6 mt-2"
        >
          Add Step
        </div>
          </div>
        </slot>
      </section>
      <footer class="p-[15px] flex border-t-2 flex-col justify-end">
        <div class="flex flex-row w-5/6 mx-auto justify-between">
          <button
            type="button"
            class="bg-slate-200 border-2 rounded-md"
            @click="enableEdit"
            v-if="!editable"
          >
            Edit Form
          </button>
          <button
            type="button"
            class="bg-slate-200 border-2 rounded-md"
            @click="() => disableEdit(id)"
            v-if="editable"
          >
            Finish editing
          </button>
          <button type="button" class="bg-red-500 p-2 rounded-md" @click="() => handleDelete(id)">
            Delete
          </button>
        </div>
      </footer>
    </div>
  </div>
</template>
