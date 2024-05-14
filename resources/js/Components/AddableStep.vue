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
      title: "",
    };
  },
  methods: {
    addStep() {
      const form = this.$refs.form$.data;
      form.jha_id = this.id;
      postStep(form);
      this.hasSaved = true;
      this.title = form.title;
    },
    handleAddHazard() {
      this.hazards[this.hazards.length] = this.hazards.length + 1;
    },
    handleNewHazard(hazard) {
      this.hazards[hazard.index] = hazard.data;
    },
    handleRemoveHazard(hazard) {
      console.log(hazard,' remove this ish from me')
      console.log(this.hazards, "hazards present")
      this.hazards = this.hazards.filter(element => (element !== hazard));
      console.log(this.hazards, "hazards present after filter")
    }
  },
};
</script>

<template>
  <div class="grid grid-cols-3 h-fit  border-b-2">
    <div class="border-r-2">
      <div>Step {{ index + 1 }}</div>
      <div class="">
        <div v-if="this.step">{{ this.title }}</div>
        <Vueform ref="form$" :endpoint="false" @submit="addStep" v-if="!this.hasSaved">
          <GroupElement name="step">
            <TextElement name="title" placeholder="Description" rules="required" />
          </GroupElement>
          <ButtonElement v-if="!this.hasSaved" name="submit" class="invisible" submits>
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
        <div class="cursor-pointer bg-green-500 w-6 rounded-full"  @click="addStep">
          <img src="/images/accept.png"/>
        </div>
      </div>
        <div
          class="bg-yellow-500 w-fit px-1 rounded-lg"
          v-if="this.hasSaved"
          @click="handleAddHazard"
        >
          + Hazard
        </div>
      </div>
    </div>
      <div class="col-span-2" :key="hazards">
        <div v-if="hazards" v-for="(hazard, index) in hazards" :key="index">
          <AddableHazard
          v-bind="step"
          :index="index" 
          :hazard="hazard"
          :present="typeof hazard !== 'number'"
          @hazardSaved="handleNewHazard"
          @deleteHazard="handleRemoveHazard"
          />
        </div>
      </div>
  </div>
</template>
