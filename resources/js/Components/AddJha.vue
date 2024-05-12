<script>
import axios from "axios";
import { ref } from "vue";
import AddStep from "../Components/AddStep.vue";

const jha = ref(null);
const steps = ref([]);

async function addJha() {
  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/jhas`);
  jha.value = data;
}

export default {
  name: 'AddJha',
  methods: {
    close() {
      this.$emit('close');
    },
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-4/6 h-5/6">
      <!-- <input v-model="title" placeholder="Add Title" /> -->
      <Vueform>
        <TextElement name="hello_world" label="Hello" placeholder="World" />
      </Vueform>
        
        <div class="border-2">
          <button
              type="button"
              class="bg-green-300 border-2 rounded-md"
              @click="close"
            >
              Close Modal
            </button>
        </div>
  
    </div>
  </div>
</template>