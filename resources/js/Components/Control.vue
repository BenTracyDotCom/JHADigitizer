<script>
import { ref } from "vue";
import Control from "../Components/Control.vue";

const updateTitle = async (title, id) => {
  const data = await axios.put(`${import.meta.env.VITE_APP_URL}/api/controls/${id}`, {
    title,
  });
  return data;
};

const deleteControl = async (id) => {
  const data = await axios.delete(`${import.meta.env.VITE_APP_URL}/api/controls/${id}`);
  return data;
};

export default {
  setup(props) {
    const newTitle = ref(null);
    const setNewTitle = (e) => {
      updateTitle(e.target.innerHTML, props.id)
      newTitle.value = e.target.innerHTML.trim();
      controlEditable.value = false;
    };
    const controlEditable = ref(false);
    const handleEdit = () => {
      controlEditable.value = false;
    };
    return { newTitle, setNewTitle, controlEditable, handleEdit };
  },
  name: "Control",
  methods: {
    handleEdit() {
      this.controlEditable = true;
    },
    handleDelete() {
      deleteControl(this.id)
      .then(() => {
        this.$emit("updateModal")
      })
    },
    updateModal() {
      this.$emit("updateModal");
    }
  },
  props: {
    id: Number,
    title: { required: true, type: String },
    editable: { type: Boolean, default: false },
  },
};
</script>
<template>
  <div>
    <div class="">
      <div class="border-r-2">
        <div v-if="editable" class="w-full flex flex-row justify-between">
          <img
            src="/images/delete-button.png"
            @click="handleDelete"
            class="h-3"
          />
          <img src="/images/edit.png" @click="handleEdit" class="h-3" />
        </div>
        <div v-if="controlEditable">
          <div
            contenteditable
            class="text-blue-500"
            @keydown.enter="setNewTitle"
          >
            {{ newTitle ? newTitle : title }}
          </div>
        </div>
        <div v-else>{{ newTitle ? newTitle : title }}</div>
      </div>
    </div>
  </div>
</template>