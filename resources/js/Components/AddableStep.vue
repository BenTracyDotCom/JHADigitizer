<script>
import axios from "axios";
import { ref } from "vue";

const step = ref(null);

async function addStep({ jha_id, title }) {
  const toSend = {
    jha_id: jha_id,
    title: title,
  };

  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/steps`, toSend);
  return data;
}

export default {
  name: "AddableStep",
  props: {
    id: Number,
    index: Number,
  },
  data() {
    return {
      step: step,
      hazards: [],
    };
  },
  methods: {
    addStep() {

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
    <div class="bg-yellow-500" @click="addStep">Add hazards</div>
  </div>
</template>
