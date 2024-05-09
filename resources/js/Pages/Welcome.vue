<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';

defineProps({
});

const handlePost = () => {
  const params = {
    title: 'job 1',
    author: 'bhiewr',
  }
  // const params = new FormData();
  // params.append('title', 'first posted problem');
  // params.append('author', 'Brenemey');
  // params.append('steps', [{title: 'step 1', hazards: [{title: 'unsafe'}]}, {title: 'step 2', hazards: 'also unsafe'}]);
  axios.post('/jhas', params);
}

</script>

<template>

  <Head title="Welcome" />
  <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div
      class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
      <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
        <main class="mt-6">
          <div class="border-2 border-red-500"> Finally made it</div>
          <button @click="handlePost">Post to /jhas</button>
        </main>
      </div>
    </div>
  </div>
</template>
