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
      hasSaved: false,
      title: ''
    };
  },
  methods: {
    addStep() {
      const form = this.$refs.form$.data;
      form.jha_id = this.id;
      postStep(form);
      this.hasSaved=true
      this.title = form.title
    },
    handleAddHazard() {
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
    <div v-if="this.step">{{ this.title }}</div>
    <Vueform ref="form$" :endpoint="false" @submit="addStep" v-if="!this.hasSaved">
      <GroupElement name="step">
        <TextareaElement name="title" placeholder="Description" rules="required" />
      </GroupElement>
      <ButtonElement v-if="!this.hasSaved" name="submit" submits> Save </ButtonElement>
    </Vueform>
    <div class="bg-yellow-500" @click="handleAddHazard" v-if="step">Add hazards</div>
    <div v-if="hazards" v-for="(hazard, index) in hazards" :key="index">
      <AddableHazard v-bind="step" :index="index"/>
    </div>
  </div>
</template>
