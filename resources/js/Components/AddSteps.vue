<script>
import axios from "axios";
import { ref } from "vue";

export default {
  name: "AddSteps",
  props: {
    id: Number,
  },
  data() {
    return {
      steps: [" eat a dick ", "don't"],
    };
  },
  methods: {
    addStep() {
      if(this.$refs.form$.every($form => ($form.data.title))){
        this.steps[this.steps.length] = ''
      }
    },
  },
};
</script>

<template>
  <div class="border-2 h-full border-red-500">
    <div v-if="steps" v-for="(step, index) in steps">
      <div>Step {{ index + 1 }}</div>
      <Vueform ref="form$">
        <GroupElement
        name="step"
        >
          <TextareaElement
          name="title"
          placeholder="Description"
          rules="required"/>
        </GroupElement>
      </Vueform>
    </div>
    <div class="bg-blue-500" @click="addStep">Add step</div>
  </div>
</template>
