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
    const setNewTitle = (text) => {
      updateTitle(text, props.id);
      newTitle.value = text;
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
    updateTitle() {
      this.setNewTitle(this.$refs.form$.data.title);
    },
    handleEdit() {
      this.controlEditable = true;
    },
    handleCancel() {
      this.controlEditable = false;
    },
    handleDelete() {
      deleteControl(this.control.id)
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
    title: String,
    editable: { type: Boolean, default: false },
    control: Object
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
          <Vueform :endpoint="false" rules="required" ref="form$" @submit="updateTitle">
            <TextElement
              name="title"
              :placeholder="`${newTitle ? newTitle : title}`"
              @keydown.esc="handleCancel"
            />
            <ButtonElement name="submit" submits class="invisible" />
          </Vueform>
        </div>
        <div v-else>{{ newTitle ? newTitle : title }}</div>
      </div>
    </div>
  </div>
</template>