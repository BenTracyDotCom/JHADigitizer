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

const postControl = async (id) => {
  const toSend = {
    hazard_id: id,
    title: "Edit me",
  };

  const { data } = await axios.post(
    `${import.meta.env.VITE_APP_URL}/api/controls`,
    toSend
  );

  return data;
};

export default {
  setup(props) {
    const newTitle = ref(null);
    const setNewTitle = (e) => {
      updateTitle(e.target.innerHTML, props.id);
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
      deleteHazard(this.id).then(() => {
        this.$emit("updateModal");
        this.mutableControls = [];
      });
    },
    updateModal() {
      this.$emit("updateModal");
      this.mutableControls = [];
    },
    addControl() {
      postControl(this.id).then((data) => {
        this.mutableControls = this.mutableControls.concat(data);
      });
    },
  },
  props: {
    id: Number,
    title: { required: true, type: String },
    controls: { type: Array },
    editable: { type: Boolean, default: false },
  },
  data() {
    return {
      mutableControls: [],
    };
  },
  computed: {
    listedControls() {
      return this.controls.concat(this.mutableControls);
    },
  },
};
</script>
<template>
  <div>
    <div class="grid grid-cols-2 border-b-2 border-b-2 border-dashed">
      <div class="border-r-2">
        <div v-if="editable" class="w-full flex flex-row justify-between">
          <img src="/images/delete-button.png" @click="handleDelete" class="h-3" />
          <img src="/images/edit.png" @click="handleEdit" class="h-3" />
        </div>
        <div v-if="hazardEditable">
          <div contenteditable class="text-blue-500" @keydown.enter="setNewTitle">
            {{ newTitle ? newTitle : title }}
          </div>
        </div>
        <div v-else>{{ newTitle ? newTitle : title }}</div>
      </div>
      <div class="h-full content-fit">
        <div v-for="(control, index) in listedControls" class="">
          <Control
            v-bind="control"
            :key="control.id"
            :editable="editable"
            @updateModal="updateModal"
          />
        </div>
      </div>
      <div v-if="editable">
      <div @click="addControl" class="bg-blue-300 p-1 rounded-xl text-center text-xs mx-auto border-2 w-3/6">Add Control</div>
      </div>
    </div>
  </div>
</template>
