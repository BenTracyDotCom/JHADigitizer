
<script>
import { ref } from 'vue';
import Control from '../Components/Control.vue';

  const titleElement = ref('')
  function setHazard(event){
    console.log(event.target).blur()
  }

  export default {
    name: 'Step',
    components: {
      Control
    },
    methods: {
      handleChange(e) {
        console.log(e.target.innerHTML)
        this.myTitle = e.target.innerHTML
        this.contentEditable = false;
      }
    },
    props: {
      step_id: { required: true, type: Number },
      id: { required: true, type: Number },
      title: { required: true, type: String },
      controls: { type: Array },
      editable: {type: Boolean, default: false }
    },
    data() {
      return {
        contentEditable: true,
        myTitle: this.title
      };
    }
  }
</script>
<template>
  <div class="grid grid-cols-2 h-full">
    <div v-if="this.contentEditable" ref="titleElement" @keydown.enter="this.handleChange">
      <div contenteditable>{{ title }}</div>
    </div>
    <div v-else>
      <div>{{ this.myTitle }}</div>
    </div>
    <div v-for="(control, index) in controls">
      <Control :key="index" v-bind="control" />
    </div>
  </div>
</template>