<template>
  <div class="bg-white text-center border-2 m-2 w-5/6 mx-auto rounded-md p-2" @click="() => { console.log('clicked') }">
    <div class="flex flex-row justify-between">
      <div class="text-2xl font-bold">{{ title }}</div>
      <div class="font-bold">{{ author }}</div>
    </div>
    <div class="text-end">{{ new Date(updated_at).toLocaleDateString() }}</div>
    <div v-for="(step, index) in steps">
      <Step />
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Step from './Step.vue';

const steps = ref([])

const fetchSteps = async (id) => {
  console.log(id, ' id')
  const { data } = await axios.get('/api/steps', { jha_id: id })
  steps.value = data
}

export default {
  name: 'JhaTile',
  props: {
    id: { required: true, type: Number },
    title: { required: true, type: String },
    author: { required: true, type: String },
    updated_at: { required: true, type: Date }
  },
  data() {
    return {
      steps: steps
    }
  },
  setup(props) {
    // onMounted(async () => {
    //   await fetchSteps(props.id)
    // })
  }
}
</script>