<script>
import axios from "axios";
import { ref } from "vue";
import AddableHazard from "../Components/AddableHazard.vue";

const step = ref(null);

async function postStep({ jha_id, title }) {
  const toSend = {
    jha_id: jha_id,
    title: title,
  };

  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/steps`, toSend);
  step.value = data;
}

export default {
  name: "AddableStep",
  props: {
    id: Number,
    index: Number,
  },
  components: {
    AddableHazard,
  },
  data() {
    return {
      step: step,
      hazards: [],
    };
  },
  methods: {
    addStep() {
      const form = this.$refs.form$.data;
      form.jha_id = this.id;
      postStep(form);
    },
    handleAddHazard() {
      console.log("clicked");
      console.log(this.hazards);
      this.hazards[this.hazards.length] = this.hazards.length + 1;
    },
    // addStep() {
    //   if(this.$refs.form$.every($form => ($form.data.title))){
    //     this.steps[this.steps.length] = ''
    //   }
    // },
  },
};
</script>

<template>
  <div class="">
    <div>Step {{ index + 1 }}</div>
    <div v-if="step">{{ step.title }}</div>
    <Vueform ref="form$" @submit="addStep" v-if="!step">
      <GroupElement name="step">
        <TextareaElement name="title" placeholder="Description" rules="required" />
      </GroupElement>
      <ButtonElement v-if="!step" name="submit" submits> Save </ButtonElement>
    </Vueform>
    <div class="bg-yellow-500" @click="handleAddHazard" v-if="step">Add hazards</div>
    <div v-if="hazards" v-for="(hazard, index) in hazards" :key="index">
      <AddableHazard v-bind="hazard" :index="index" :id="step.id"/>
    </div>
  </div>
</template>
