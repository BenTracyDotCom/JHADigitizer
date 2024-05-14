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
    title: "Edit me",
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
    title: { required: true, type: String },
    hazards: { type: Array, default: [] },
    editable: { type: Boolean, default: false },
  },
  methods: {
    updateTitle() {
      this.setNewTitle(this.$refs.form$.data.title)
    },
    handleEdit() {
      this.stepEditable = true;
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
      if(this.hazards){
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
        <div v-if="editable" class="w-full flex flex-row justify-between cursor-pointer">
          <img src="/images/delete-button.png" @click="handleDelete" class="h-3" />
          <img src="/images/edit.png" @click="handleEdit" class="h-3" />
        </div>
        <div v-if="num || num === 0" class="font-bold text-sm">Step {{ num + 1 }}</div>
        <div v-if="stepEditable">
        <Vueform :endpoint="false" rules="required" ref="form$" @submit="updateTitle"> 
        <TextElement
        name="title"
        :placeholder="`${ newTitle ? newTitle : title}`"
        />
        <ButtonElement name="submit" submits class="invisible"/>
        </Vueform>
          <!-- <div contenteditable class="text-blue-500 border-2 rounded-full pl-2" @keydown.enter="setNewTitle">
            {{ newTitle ? newTitle : title }}
          </div> -->
        </div>
        <div v-else>{{ newTitle ? newTitle : title }}</div>
      <div v-if="editable">
        <div
          @click="addHazard"
          class="bg-yellow-300 p-1 rounded-xl text-center text-sm mx-auto border-2 w-3/6"
        >
          Add hazard
        </div>
      </div>
      </div>
      <div class="col-span-2 h-full content-fit">
        <div v-for="(hazard, index) in listedHazards" class="">
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
