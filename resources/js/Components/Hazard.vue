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
    title: "New Control",
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
    const setNewTitle = (text) => {
      updateTitle(text, props.id);
      newTitle.value = text;
      hazardEditable.value = false;
    };
    const hazardEditable = ref(false);
    const handleEdit = () => {
      hazardEditable.value = false;
    };
    return { newTitle, setNewTitle, hazardEditable, handleEdit };
  },
  name: "Hazard",
  components: {
    Control,
  },
  methods: {
    updateTitle() {
      this.setNewTitle(this.$refs.form$.data.title);
    },
    handleEdit() {
      this.hazardEditable = true;
    },
    handleDelete() {
      deleteHazard(this.id).then(() => {
        this.mutableControls = [];
        this.$emit("updateModal");
      });
    },
    handleCancel() {
      this.hazardEditable = false;
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
    title: String,
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
      return this.mutableControls.concat(this.controls);
    },
  },
};
</script>
<template>
  <div>
    <div class="grid grid-cols-2 border-b-2 border-b-2 border-dashed">
      <div class="border-r-2">
        <div class="flex flex-row-reverse justify-between pr-1">
          <div
            v-if="editable"
            class="flex flex-col h-full space-y-2 py-1 justify-between cursor-pointer"
            id="buttonContainer"
          >
            <img src="/images/edit.png" @click="handleEdit" class="h-3 w-3" />
            <img src="/images/delete-button.png" @click="handleDelete" class="h-3 w-3" />
            <div @click="addControl" class="bg-blue-600 p-1 rounded-full h-3 w-3"></div>
          </div>
          <div v-if="hazardEditable">
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
      <div class="h-full content-fit">
        <div v-for="(control, index) in listedControls">
          <Control
            v-bind="control"
            :control="control"
            :key="index"
            :editable="editable"
            @updateModal="updateModal"
          />
        </div>
      </div>
    </div>
  </div>
</template>
