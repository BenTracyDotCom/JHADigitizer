<script>
import axios from "axios";
import { ref } from "vue";
import AddableControl from "../Components/AddableControl.vue";

// TODO: Handle 'controlSaved' event from control

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
      hasSaved: false,
      title: "",
    };
  },
  methods: {
    sendHazard() {
      const form = this.$refs.form$.data;
      form.step_id = this.id;
      postHazard(form);
      this.hasSaved = true;
      this.title = form.title;
    },
    handleAddControl() {
      this.controls[this.controls.length] = this.controls.length + 1;
    },
    handleRemoveControl(control) {
      console.log(control, ' we deleting this')
      console.log(this.controls.filter(element => (element !== control)))
      this.controls = this.controls.filter(element => (element !== control))
      // const toRemove = this.controls.splice(0, 1);
    },
    handleNewControl(control) {
      console.log(control);
      this.controls[control.index] = control.data;
      console.log(this.controls, "updated array");
    },
  },
};
</script>

<template>
  <div class="grid grid-cols-2">
    <div class="border-r-2">
      <Vueform :endpoint="false" ref="form$" @submit="sendHazard" v-if="!this.hasSaved">
        <GroupElement name="hazard">
          <TextElement name="title" placeholder="Hazard" rules="required" />
        </GroupElement>
        <ButtonElement v-if="!hasSaved" name="submit" submits class="invisible">
          Save
        </ButtonElement>
      </Vueform>
      <div class="flex flex-row justify-around -mt-12 mb-2" v-if="!this.hasSaved">
        <div
          class="w-fit rounded-full bg-red-500 px-2 h-6 pt-1 text-xs font-black cursor-pointer"
          @click="this.$emit('deleteControl', control)"
        >
          X
        </div>
        <div class="cursor-pointer bg-green-500 w-6 rounded-full" @click="sendHazard">
          <img src="/images/accept.png" />
        </div>
      </div>
      <div v-else>{{ this.title }}</div>
      <div
        class="bg-teal-300 w-fit px-1 rounded-lg"
        @click="handleAddControl"
        v-if="hasSaved"
      >
        + Control
      </div>
    </div>
    <div>
      <div v-if="controls" v-for="(control, index) in controls" :key="index">
        <AddableControl
          v-bind="hazard"
          :hazard_id="hazard.id"
          :index="index"
          :control="control"
          :present="typeof control !== 'number'"
          @controlSaved="handleNewControl"
          @deleteControl="handleRemoveControl"
        />
      </div>
    </div>
  </div>
</template>
