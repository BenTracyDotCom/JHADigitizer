
<script>
  export default {
    name: 'Control',
    props: {
      hazard_id: { required: true, type: Number},
      id: { required: true, type: Number },
      title: { required: true, type: String },
      editable: {type: Boolean, default: false }
    }
  }
</script>
<template>
  <div class="">
    <div class="border-l-2" @click="() => {console.log('clicked')}">
      <div>{{ title }}</div>
    </div>
  </div>
</template>