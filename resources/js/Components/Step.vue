
<script>
import Hazard from '../Components/Hazard.vue';

  export default {
    name: 'Step',
    components: {
      Hazard
    },
    props: {
      num: Number,
      id: { required: true, type: Number },
      title: { required: true, type: String },
      hazards: { type: Array, default: [] },
      editable: {type: Boolean, default: false }
    },
    data() {
      return {
        controls: this.hazards.controls
      }
    }
  }
</script>
<template>
  <div>
    <div class="grid grid-cols-3 ">
      <div class="border-r-2" @click="() => {console.log('clicked')}">
        <div>Step {{ num + 1 }}</div>
        <div>{{ title }}</div>
      </div>
      <div class="col-span-2">
        <div v-for="(hazard, index) in hazards" class="h-fit">
          <Hazard v-bind="hazard" :key="index"/>
        </div>
      </div>
    </div>
  </div>
</template>