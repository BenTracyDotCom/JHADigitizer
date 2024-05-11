
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const hazards = ref([])

const fetchHazards = async (id) => {
      const { data } = await axios.get('/hazards', { step_id: id })
      hazards.value = data
  }
  
  export default {
    name: 'Step',
    props: {
      num: Number,
      id: { required: true, type: Number },
      title: { required: true, type: String },
      editable: {type: Boolean, default: false }
    }
  }
</script>
<template>
  <div class="grid grid-cols-3">
    <div class="border-2" @click="() => {console.log('clicked')}">
      <div>Step</div>
      <div>{{ title }}</div>
    </div>
    <div class="border-2">
      Column 2
    </div>
    <div class="border-2">
      Column 3
    </div>
  </div>
</template>