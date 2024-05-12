<script>
import axios from "axios";
import { ref } from "vue";
import AddableControl from "../Components/AddableControl.vue";

const hazard = ref(null);

async function postHazard({ step_id, title }) {
  const toSend = {
    step_id: step_id,
    title: title,
  };

  const { data } = await axios.post(
    `${import.meta.env.VITE_APP_URL}/api/hazards`,
    toSend
  );
  hazard.value = data;
}
export default {
  name: "AddableHazard",
  props: {
    id: Number,
  },
  components: {
    AddableControl,
  },
  data() {
    return {
      hazard: hazard,
      controls: [],
    };
  },
  methods: {
    sendHazard() {
      const form = this.$refs.form$.data;
      form.step_id = this.id;
      postHazard(form);
    },
    handleAddControl() {
      this.controls[this.controls.length] = this.controls.length + 1;
    },
  },
};
</script>

<template>
  <div>
    <Vueform :endpoint="false" ref="form$" @submit="sendHazard">
      <GroupElement name="hazard">
        <TextElement name="title" placeholder="Hazard" rules="required" />
      </GroupElement>
      <ButtonElement v-if="!hazard" name="submit" submits> Save </ButtonElement>
    </Vueform>
    <div class="bg-teal-300" @click="handleAddControl" v-if="hazard">Add Controls</div>
    <div v-if="controls" v-for="(control, index) in controls" :key="index">
      <AddableControl v-bind="control" :index="index" />
    </div>
  </div>
</template>
