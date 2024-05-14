<script>
import { ref } from "vue";
import Control from "../Components/Control.vue";

const updateTitle = async (title, id) => {
  const data = await axios.put(`${import.meta.env.VITE_APP_URL}/api/hazards/${id}`, {
    title,
  });
  return data;
};

const deleteHazard = async (id) => {
  const data = await axios.delete(`${import.meta.env.VITE_APP_URL}/api/hazards/${id}`);
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
      console.log(e.target.innerHTML, " title");
      updateTitle(e.target.innerHTML, props.id).then((res) => {
        console.log(res);
      });
      newTitle.value = e.target.innerHTML.trim();
      hazardEditable.value = false;
    };
    const hazardEditable = ref(false);
    const handleEdit = () => {
      hazardEditable.value = false;
      //this.$emit("editHazard", props.id);
    };
    return { newTitle, setNewTitle, hazardEditable, handleEdit };
  },
  name: "Hazard",
  components: {
    Control,
  },
  methods: {
    handleEdit() {
      this.hazardEditable = true;
    },
    handleDelete() {
      deleteHazard(this.id)
      .then(() => {
        this.$emit("updateModal")
      })
    },
    updateModal() {
      this.$emit("updateModal");
    }
  },
  props: {
    id: { required: true, type: Number },
    title: { required: true, type: String },
    controls: { type: Array },
    editable: { type: Boolean, default: false },
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
        <div v-if="hazardEditable">
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
      <div class="col-span-2 h-full content-fit">
        <div v-for="(control, index) in controls" class="">
          <Control v-bind="control" :key="control.id" :editable="editable" @updateModal="updateModal"/>
        </div>
      </div>
    </div>
  </div>
</template>
