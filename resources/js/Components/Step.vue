<template>
  <div class="w-full text-center border-2 m-2" @click="() => {console.log('clicked')}">
    <div>{{ title }}</div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
// import axios from 'axios';

// const steps = ref([])

// const fetchSteps = async (id) => {
//     const { data } = await axios.get('/steps', { jha_id: id })
//     steps.value = data
// }

export default {
  name: 'Step',
  props: {
    id: { required: true, type: Number },
    title: { required: true, type: String },
  }
}
</script>