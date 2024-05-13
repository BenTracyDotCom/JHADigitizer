
<script>
import Hazard from '../Components/Hazard.vue';

const updateTitle = async (title, id) => {
  const data = await axios.put(`${import.meta.env.VITE_APP_URL}/api/jhas/${id}`, { title });
  return data;
};
const deleteStep = async (id) => {
  
}

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
    methods: {
      handleEdit() {
        this.stepEditable=true
      },
      handleDelete(id) {
        this.$emit("deleteStep", id)
      }
    },
    data() {
      return {
        controls: this.hazards.controls,
        stepEditable: false
      }
    }
  }
</script>
<template>
  <div>
    <div class="grid grid-cols-3 ">
      <div class="border-r-2">
        <div v-if="editable" class="w-full flex flex-row justify-between">
          <img src="/images/delete-button.png" @click="() => handleDelete(id)" class="h-3"/>
          <img src="/images/edit.png"  @click="handleEdit" class="h-3"/>
        </div>
        <div>Step {{ num + 1 }}</div>
        <div>{{ title }}</div>
      </div>
      <div class="col-span-2 h-full border-green-500 border-2 content-fit">
        <div v-for="(hazard, index) in hazards" class="">
          <Hazard v-bind="hazard" :key="index"/>
        </div>
      </div>
    </div>
  </div>
</template>