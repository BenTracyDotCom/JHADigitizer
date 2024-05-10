Dashboard

<script>
import axios from 'axios';
import Modal from '../Components/Modal.vue';
import Header from '../Components/Header.vue';
import Footer from '../Components/Footer.vue';
import JhaTile from '../Components/JhaTile.vue';
import { ref, onMounted } from 'vue';

const jhas = ref([]);
//Implement loading icon if time allows
const fetching = ref(false);

async function fetchJhas() {
  const { data } = await axios.get('/api/jhas');
  jhas.value = data;
}

export default {
  name: 'App',
  components: {
    Modal,
    Header,
    Footer,
    JhaTile,
  },
  data() {
    return {
      isModalVisible: false,
      jhas: jhas,
    }
  },
  methods: {
    showModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    }
  },
  setup() {
    onMounted(async () => {
      await fetchJhas()
    });
  }
}

</script>

<template>
  <Header />

  <div className="border-2">Made it</div>
  <Modal v-show="isModalVisible" @close="closeModal"></Modal>
  <div v-for="(jha, index) in jhas">
    <JhaTile :key="index" v-bind="jha"/>
  </div>
  <button type="button" class="border-2 bg-green-100 rounded-lg p-2" @click="showModal">Open modal!</button>
  <Footer />
</template>
