<script>
import axios from "axios";
import { ref } from "vue";

export default {
  name: 'AddableControl',
  props: {
    id: { required: true, type: Number}
  }
}

</script>

<template>
  <div>This gon be a control for Hazard {{id}}</div>
</template>