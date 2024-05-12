<script>
import axios from "axios";
import { ref } from "vue";

export default {
  name: "AddSteps",
  props: {
    rid: { required: false, type: Number},
    id: Object
  }
}
</script>

<template>
  <div>Step for </div><div>{{ JSON.stringify(id) }}</div>
</template>
