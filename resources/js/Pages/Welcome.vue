<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';

defineProps({
});

const handlePost = () => {
  const params = {
    title: 'job 1',
    author: 'brengeley',
  }
  axios.post('/jhas', params);
}

</script>

<template>

  <Head title="Welcome" />
<div id="app"></div>
</template>
