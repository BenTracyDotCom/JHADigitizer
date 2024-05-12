<script>
import axios from "axios";
import { ref, watch } from "vue";
import AddableStep from "../Components/AddableStep.vue";
import { getCurrentInstance } from "vue";

const jha = ref(null);

//From this component, I want to be able to add steps to my "steps" array to map. I want to keep an "add step" button, but only actually add a step then each of the others is populated with at least a 'title'.

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
      this.$refs.form$.clear();
    },
    handleAddStep() {
      if (!this.steps.length || Object.keys(this.steps).every((step) => !!step)) {
        this.steps[this.steps.length] = this.steps.length + 1;
      }
    },
    handleFinish() {
      this.$emit("finishAdding")
      this.$emit("close")
      this.jha = null
    }
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
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-4/6 h-5/6">
      <!-- <input v-model="title" placeholder="Add Title" /> -->
      <Vueform :endpoint="false" ref="form$" @submit="sendJha" v-if="!jha">
        <!-- <StaticElement name="head">
          <div>Job</div>
        </StaticElement> -->
        <div class="font-bold text-2xl pt-2 pl-2 -mb-2">Job</div>
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
        <TextareaElement
          label="Description"
          name="description"
          placeholder="Optional"
          class="px-2"
        />
        <ButtonElement v-if="!jha" class="mx-auto" name="submit" submits>
          Create JHA Form
        </ButtonElement>
      </Vueform>
      <div v-else class="border-b-2 border-black pl-2 text-center">
        <div class="text-2xl font-bold pt-2">{{ this.jha.title }}</div>
        <div class="">
          Submitted by {{ this.jha.author }} on
          {{ new Date(this.jha.created_at).toLocaleDateString() }}
        </div>
      </div>
      <!-- <button type="button" @click="sendJha">
        Create JHA form
      </button> -->
      <div v-if="jha" class="h-full">
        <div class="w-full flex flex-row justify-around">
          <div v-if="steps" v-for="(step, index) in steps" :key="index">
            <AddableStep v-bind="jha" :index="index" />
          </div>
        </div>
        <button type="button" class="bg-blue-500 rounded-md p-2" @click="handleAddStep">
          Add step
        </button>
        <button type="button" class="bg-green-500 rounded-md p-2" @click="handleFinish">
          Save & Exit
        </button>
        <div class="p2 bg-red-500 self-end" @click="close">Close</div>
      </div>
    </div>
  </div>
</template>
