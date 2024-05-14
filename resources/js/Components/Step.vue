<script>
import { onUnmounted, ref } from "vue";
import Hazard from "../Components/Hazard.vue";

const updateTitle = async (title, id) => {
  const data = await axios.put(`${import.meta.env.VITE_APP_URL}/api/steps/${id}`, {
    title,
  });
  return data;
};
const deleteStep = async (id) => {
  const data = await axios.delete(`${import.meta.env.VITE_APP_URL}/api/steps/${id}`);
  return data;
};

export default {
  setup(props) {
    // onUnmounted(() => {
    //   newTitle.value = null
    //   console.log('beforeUnmount')
    // })
    const newTitle = ref(null);
    const setNewTitle = (e) => {
      updateTitle(e.target.innerHTML, props.id)
      newTitle.value = e.target.innerHTML.trim();
      stepEditable.value = false;
    };
    const stepEditable = ref(false);
    const handleEdit = () => {
      stepEditable.value = false;
      this.$emit("editStep", props.id);
    };

    return { newTitle, setNewTitle, stepEditable, handleEdit };
  },
  name: "Step",
  components: {
    Hazard,
  },
  props: {
    num: Number,
    id: Number,
    title: { required: true, type: String },
    hazards: { type: Array, default: [] },
    editable: { type: Boolean, default: false },
  },
  methods: {
    handleEdit() {
      this.stepEditable = true;
    },
    handleDelete() {
      deleteStep(this.id)
      .then(() => (
        this.$emit("updateModal")
      ))
    },
    updateModal() {
      this.$emit("updateModal");
    }
    // handleChange(e) {
    //   updateTitle(e.target.innerHTML, this.id)
    //   .then(res => {
    //     this.stepEditable = false;
    //   })
    // }
  },
  data() {
    return {
      controls: this.hazards.controls,
      //stepEditable: false,
    };
  },
};
</script>
<template>
  <div>
    <div class="grid grid-cols-3">
      <div class="border-r-2">
        <div v-if="editable" class="w-full flex flex-row justify-between">
          <img
            src="/images/delete-button.png"
            @click="handleDelete"
            class="h-3"
          />
          <img src="/images/edit.png" @click="handleEdit" class="h-3" />
        </div>
        <div v-if="num">Step {{ num + 1 }}</div>
        <div v-if="stepEditable">
          <div contenteditable class="text-blue-500" @keydown.enter="setNewTitle">
            {{ newTitle ? newTitle : title }}
          </div>
        </div>
        <div v-else>{{ newTitle ? newTitle : title }}</div>
      </div>
      <div class="col-span-2 h-full content-fit">
        <div v-for="(hazard, index) in hazards" class="">
          <Hazard
            v-bind="hazard"
            :key="index"
            :editable="editable"
            @updateModal="updateModal"
          />
        </div>
      </div>
    </div>
  </div>
</template>
