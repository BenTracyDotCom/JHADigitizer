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

const postHazard = async (id) => {
  const toSend = {
    step_id: id,
    title: "New Hazard",
  };

  const { data } = await axios.post(
    `${import.meta.env.VITE_APP_URL}/api/hazards`,
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
    title: String,
    hazards: { type: Array, default: [] },
    editable: { type: Boolean, default: false },
  },
  methods: {
    updateTitle() {
      this.setNewTitle(this.$refs.form$.data.title);
    },
    handleEdit() {
      this.stepEditable = true;
    },
    handleCancel() {
      this.stepEditable = false;
    },
    handleDelete() {
      deleteStep(this.id).then(() => {
        this.$emit("updateModal");
        this.mutableHazards = [];
      });
    },
    updateModal() {
      this.$emit("updateModal");
      this.mutableHazards = [];
    },
    addHazard() {
      postHazard(this.id).then((data) => {
        this.mutableHazards = this.mutableHazards.concat(data);
      });
    },
  },
  data() {
    return {
      controls: this.hazards.controls,
      mutableHazards: [],
    };
  },
  computed: {
    listedHazards() {
      if (this.hazards) {
        return this.hazards.concat(this.mutableHazards);
      }
    },
  },
};
</script>
<template>
  <div>
    <div class="grid grid-cols-3">
      <div class="border-r-2">
        <div class="flex flex-row-reverse justify-between pr-2">
          <div>
            <div v-if="editable" class="flex flex-col h-full space-y-2 py-1 justify-between cursor-pointer" id="buttonContainer">
              <img src="/images/edit.png" @click="handleEdit" class="h-3 w-3" />
              <img src="/images/delete-button.png" @click="handleDelete" class="h-3 w-3" />
              <div
                @click="addHazard"
                class="bg-amber-400 p-1 rounded-full h-3 w-3"
              ></div>
            </div>
          </div>
          <div>
            <div v-if="num || num === 0" class="font-bold text-sm">Step {{ num + 1 }}</div>
            <div v-if="stepEditable">
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
        <div v-if="editable">
        </div>
      </div>
      <div class="col-span-2 h-full content-fit">
        <div v-for="(hazard, index) in listedHazards">
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
