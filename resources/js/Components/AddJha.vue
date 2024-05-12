<script>
import axios from "axios";
import { ref } from "vue";
import AddStep from "../Components/AddStep.vue";

const jha = ref(null);
const steps = ref([]);

async function addJha() {
  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/jhas`, {
    title: "Test JHA",
    author: "Brengeley"
  });
  jha.value = data;
}

export default {
  name: "AddJha",
  methods: {
    close() {
      this.$emit("close");
    },
    sendJha() {
      addJha()
    }
  },
  data() {
    return {
      schema: {
        title: { type: "text", label: "Title" },
        author: { type: "text", label: "Author" },
      },
      jha: jha
    };
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-4/6 h-5/6">
      <!-- <input v-model="title" placeholder="Add Title" /> -->
      <Vueform :schema="schema"></Vueform>
      <button type="button" @click="sendJha">
        Create JHA form
      </button>
      <div v-if="jha">You can now add steps to the jha.</div>
      <div class="border-2">
        <button type="button" class="bg-green-300 border-2 rounded-md" @click="close">
          Close Modal
        </button>
      </div>
    </div>
  </div>
</template>
