Dashboard

<script>
import axios from "axios";
import AddJha from "../Components/AddJha.vue";
import Modal from "../Components/Modal.vue";
import Header from "../Components/Header.vue";
import Footer from "../Components/Footer.vue";
import JhaTile from "../Components/JhaTile.vue";
import { ref, onMounted } from "vue";

const jhas = ref([]);
//Implement loading icon if time allows
const fetching = ref(false);

//TODO: handle errors/failures
async function fetchJhas() {
  const { data } = await axios.get(`${import.meta.env.VITE_APP_URL}/api/jhas`);
  jhas.value = data;
}

async function deleteJha(id) {
  const { data } = await axios.delete(`${import.meta.env.VITE_APP_URL}/api/jhas/${id}`);
  jhas.value = data;
}

async function modifyJha({ id, title, author, description}) {
  const toUpdate = {
    title: title,
    author: author,
    description: description
  };

  const { data } = await axios.put(`${import.meta.env.VITE_APP_URL}/api/jhas/${id}`, toUpdate);
  jhas.value = data;
} 

export default {
  name: "App",
  components: {
    AddJha,
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
      jha: null,
    };
  },
  methods: {
    showModal(jha) {
      this.jha = jha;
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
    handleAdd() {
      fetchJhas()
    },
    updateJha(e) {
      modifyJha(e)
    }
  },
  setup() {
    onMounted(async () => {
      await fetchJhas();
    });
  },
};
</script>

<template>
  <div class="w-full">
    <Header />
    <AddJha v-show="isJhaVisible" @close="closeJha" @finishAdding="handleAdd"></AddJha>
    <Modal
      v-show="isModalVisible"
      v-bind="jha"
      @close="closeModal"
      @deleteJha="handleDelete"
      @addJha="handleAdd"
      @finishEditing="updateJha"
    >
      <!-- <template v-slot:body>
      <JhaTile v-bind="jha"/>
    </template> -->
    </Modal>
    <div :key="jhas">
      <div v-for="(jha, index) in jhas">
        <JhaTile
          :key="index"
          v-bind="jha"
          @click="
            () => {
              showModal(jha);
            }
          "
        />
      </div>
      <div class="w-full flex flex-around">
        <button
          type="button"
          class="border-2 bg-green-100 rounded-lg p-2 mx-auto"
          @click="showJha"
        >
          Add a JHA
        </button>
      </div>
    </div>
    <Footer />
  </div>
</template>
