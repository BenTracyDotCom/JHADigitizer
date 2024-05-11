
<script>
import Control from '../Components/Control.vue';

  export default {
    name: 'Step',
    components: {
      Control
    },
    props: {
      step_id: { required: true, type: Number },
      id: { required: true, type: Number },
      title: { required: true, type: String },
      controls: { type: Array },
      editable: {type: Boolean, default: false }
    }
  }
</script>
<template>
  <div class="grid grid-cols-2 h-full">
    <div @click="() => {console.log('clicked')}">
      <div>{{ title }}</div>
    </div>
    <div v-for="(control, index) in controls">
      <Control :key="index" v-bind="control" />
    </div>
  </div>
</template>