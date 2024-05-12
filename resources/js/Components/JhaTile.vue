<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import Modal from "../Components/Modal.vue";
import Step from "./Step.vue";

const steps = ref([]);

const fetchSteps = async (id) => {
  console.log(id, " id");
  const { data } = await axios.get("/api/steps", { jha_id: id });
  steps.value = data;
};

const deleteJha = async (id) => {
  const { data } = await axios.delete(`api/jhas/${id}`);
  steps.value = data;
};

export default {
  name: "JhaTile",
  conponents: {
    Modal,
  },
  props: {
    id: { required: true, type: Number },
    title: { required: true, type: String },
    author: { required: true, type: String },
    updated_at: { required: true, type: String },
  },
  data() {
    return {
      steps: steps,
    };
  },
  methods: {
    handleDelete() {
      this.$emit("deleteJha", this.id);
    },
  },
  setup(props) {
    // onMounted(async () => {
    //   await fetchSteps(props.id)
    // })
  },
};
</script>

<template>
  <div class="bg-white border-2 text-center m-2 w-5/6 mx-auto rounded-md p-2">
    <div class="flex flex-row justify-between">
      <div class="text-2xl font-bold">{{ title }}</div>
      <div class="font-bold">{{ author }}</div>
    </div>
    <div class="flex flex-row justify-between">
      <div class="">{{ new Date(updated_at).toLocaleDateString() }}</div>
    </div>
  </div>
</template>
