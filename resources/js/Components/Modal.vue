<script>
import { ref } from "vue";
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

const deleteStep = async (id) => {
  const data = await axios.delete(`${import.meta.env.VITE_APP_URL}/api/steps/${id}`);
  return data;
};

export default {
  name: "Modal",
  components: {
    Step,
  },
  methods: {
    close() {
      this.$emit("close");
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
      this.listedSteps = this.steps;
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
    removeStep(id) {
      deleteStep(id).then((res) => {
        const toUpdate = {
          steps: res.data,
        };
        this.$emit("updateModal", id);
      });
    },
      editStep(id) {
        this.$emit("updateModal", id);
      }
      //this.$emit('deleteStep', id)
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
      listedSteps: this.steps,
    };
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
              <Vueform ref="form$">
                <TextElement name="title" placeholder="Title" rules="required" />
              </Vueform>
            </div>
            <div v-if="editable && !titleEditable">
              <img
                src="/images/edit.png"
                class="size-4 cursor-pointer"
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
          <div class="text-md" v-if="!authorEditable">
            Created by {{ this.newAuthor ? this.newAuthor : author }}
          </div>
          <div v-else>
            <Vueform ref="form$">
              <TextElement name="author" placeholder="Author" rules="required" />
            </Vueform>
          </div>
          <div>
            <div v-if="editable && !authorEditable">
              <img
                src="/images/edit.png"
                class="size-4 cursor-pointer"
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
          <div v-for="(listedStep, index) in steps">
            <div class="border-b-2 border-x-2">
              <Step
                :key="index"
                :num="index"
                v-bind="listedStep"
                :editable="editable"
                @deleteStep="removeStep"
                @editStep="editStep"
              />
            </div>
          </div>
        </slot>
      </section>
      <footer class="p-[15px] flex border-t-2 flex-col justify-end">
        <button
          type="button"
          class="bg-slate-200 border-2 rounded-md"
          @click="enableEdit"
          v-if="!editable"
        >
          Edit Job Hazard Analysis
        </button>
        <button
          type="button"
          class="bg-slate-200 border-2 rounded-md"
          @click="() => disableEdit(id)"
          v-if="editable"
        >
          Finish editing
        </button>
        <button type="button" class="bg-red-500 p-2" @click="() => handleDelete(id)">
          Delete
        </button>
      </footer>
    </div>
  </div>
</template>
