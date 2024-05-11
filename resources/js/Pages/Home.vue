Dashboard

<script>
import axios from 'axios';
import Jha from '../Components/Jha.vue'
import Modal from '../Components/Modal.vue';
import Header from '../Components/Header.vue';
import Footer from '../Components/Footer.vue';
import JhaTile from '../Components/JhaTile.vue';
import { ref, onMounted } from 'vue';

const jhas = ref([]);
//Implement loading icon if time allows
const fetching = ref(false);


//TODO: handle errors/failures
async function fetchJhas() {
  const { data } = await axios.get(`${import.meta.env.VITE_APP_URL}/api/jhas`);
  jhas.value = data;
}

async function deleteJha(id) {
  const { data } = await axios.delete(`${import.meta.env.VITE_APP_URL}/api/jhas/${id}`)
  jhas.value = data;
}

export default {
  name: 'App',
  components: {
    Jha,
    Modal,
    Header,
    Footer,
    JhaTile,
  },
  data() {
    return {
      isModalVisible: false,
      isJhaVisible: false,
      jhas: jhas,
      jha: null
    }
  },
  methods: {
    showModal(jha) {
      this.jha = jha
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    showJha() {
      this.isJhaVisible = true;
    },
    closeJha() {
      this.isJhaVisible = false;
    },
    handleDelete(id) {
      deleteJha(id);
    },
    showJha(jha) {
      this.jha = jha
      this.isJhaVisible = true;
    },
    hideJha() {
      this.isJhaVisible = false;
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
  <div class="w-full">
    <Header />
    <div className="border-2">Made it</div>
    <Jha v-show="isJhaVisible" @close="closeJha"></Jha>
    <Modal v-show="isModalVisible" v-bind="jha" @close="closeModal">
      <template v-slot:header>
      </template>
    <!-- <template v-slot:body>
      <JhaTile v-bind="jha"/>
    </template> -->
    </Modal>
    <div v-for="(jha, index) in jhas">
      <JhaTile :key="index" v-bind="jha" @click="() => { showModal(jha) }" @deleteJha="handleDelete"/>
    </div>
    <div class="w-full flex flex-around">
      <button type="button" class="border-2 bg-green-100 rounded-lg p-2  mx-auto" @click="showJha">Add a JHA</button>
      </div>
    <Footer />
  </div>
</template>
