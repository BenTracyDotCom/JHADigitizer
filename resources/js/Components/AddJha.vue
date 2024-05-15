<script>
import axios from "axios";
import { ref, watch } from "vue";
import AddableStep from "../Components/AddableStep.vue";
import { getCurrentInstance } from "vue";

const jha = ref(null);

async function addJha({ title, author, description }) {
  const toSend = {
    title: title,
    author: author,
  };
  if (description) {
    toSend.description = description;
  }

  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/jhas`, toSend);
  jha.value = data;
}

export default {
  name: "AddJha",
  components: {
    AddableStep,
  },
  methods: {
    close() {
      this.steps = [];
      this.jha = null;
      this.$emit("close");
    },
    sendJha() {
      const form = this.$refs.form$.data;
      const toSubmit = {
        title: form.title,
        author: `${form.firstname} ${form.lastname}`,
      };
      if (form.description) {
        toSubmit.description = form.description;
      }
      addJha(toSubmit);
      this.$emit("finishAdding");
    },
    handleAddStep() {
      if (!this.steps.length || Object.keys(this.steps).every((step) => !!step)) {
        this.steps[this.steps.length] = this.steps.length + 1;
      }
    },
    handleFinish() {
      this.$emit("finishAdding");
      this.$emit("close");
      this.steps = []
      this.jha = null;
    },
  },
  data() {
    return {
      jha: jha,
      // This is redundant if we're using the ref above
      steps: [],
    };
  },
  setup(props, context) {
    watch(jha, () => {
      context.emit("addJha");
    });
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div
      class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-5/6 h-fit p-2"
    >
  <div class="text-red-500 text-3xl h-min w-full flex flex-row justify-end" >
  <div @click="close" class="cursor-pointer -mb-6 z-1000">x</div>
  </div>
      <div class="w-full flex flex-row justify-between px-2">
        <div class="font-bold text-2xl" v-if="!jha">Job</div>
      </div>
      <Vueform :endpoint="false" ref="form$" @submit="sendJha" v-if="!jha">
        <TextElement name="title" rules="required" class="px-2" />
        <GroupElement
          name="author"
          label="Author"
          :format-data="(n, v) => `${n} ${v}`"
          class="px-2"
        >
          <TextElement
            name="firstname"
            placeholder="First name"
            rules="required"
            class="w-full"
            columns="6"
          />
          <TextElement
            name="lastname"
            placeholder="Last name"
            rules="required"
            class="w-full"
            :columns="6"
          />
        </GroupElement>
        <!-- <TextareaElement
          label="Description"
          name="description"
          placeholder="Optional"
          class="px-2"
        /> -->
        <ButtonElement v-if="!jha" class="mx-auto mb-2" name="submit" submits>
          Create Form
        </ButtonElement>
      </Vueform>
      <div v-else class="border-b-2 border-black pl-2">
        <div class="flex flex-row justify-between">
          <div>
            <div class="text-2xl font-bold">{{ this.jha.title }}</div>
            <div class="">
              Created by {{ this.jha.author }} on
              {{ new Date(this.jha.created_at).toLocaleDateString() }}
          </div>
        </div>
          </div>
          
      </div>
      <div v-if="jha" class="h-full">
        <div class="grid grid-cols-3 border-b-2">
          <div>Steps</div>
          <div>Hazards</div>
          <div>Controls</div>
        </div>
        <div v-if="steps" v-for="(step, index) in steps" :key="index">
          <AddableStep v-bind="jha" :index="index" />
        </div>
        <div class="w-full flex flex-row justify-around pt-3 bb-2">
          <button type="button" class="bg-blue-500 rounded-md p-2" @click="handleAddStep">
            Add step
          </button>
          <button type="button" class="bg-green-500 rounded-md p-2" @click="handleFinish">
            Save & Exit
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
