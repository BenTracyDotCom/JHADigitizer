Dashboard

<script>
import { Head } from '@inertiajs/vue3';
import Modal from '../Components/Modal.vue';

export default {
  name: 'App',
  components: {
    Modal,
  },
  data() {
    return {
      isModalVisible: false,
    }
  },
  methods: {
    showModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    }
  }
};
</script>

<template>
    <Head title="JHA Navigator" />
    <button type="button" class="btn" @click="showModal">Open modal!</button>
<Modal v-show="isModalVisible" @close="closeModal"></Modal>

<div className="border-2">Made it</div>
</template>

