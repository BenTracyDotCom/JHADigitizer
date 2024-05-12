<script>
import axios from "axios";
import { ref } from "vue";

const hazard = ref(null);

async function postHazard({ step_id, title }) {
  const toSend = {
    step_id: step_id,
    title: title,
  };

  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/hazards`, toSend);
  hazard.value = data;

}
export default {
  name: 'AddableHazard'
}
</script>

<template>
  <div>
    Hazard goes here
  </div>
</template>