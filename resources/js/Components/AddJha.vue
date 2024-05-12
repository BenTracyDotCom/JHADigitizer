<script>
import axios from "axios";
import { ref } from "vue";
import AddSteps from "../Components/AddSteps.vue";

const jha = ref(null);
const steps = ref([]);

async function addJha({ title, author, description }) {
  const toSend = {
    title: title,
    author: author,
  };
  if (description) {
    toSend.description = description;
  }
  console.log(toSend);

  const { data } = await axios.post(`${import.meta.env.VITE_APP_URL}/api/jhas`, toSend);
  jha.value = data;
}

export default {
  name: "AddJha",
  components: {
    AddSteps
  },
  methods: {
    close() {
      this.$emit("close");
    },
    sendJha() {
      const form = this.$refs.form$.data
      const toSubmit = {
        title: form.title,
        author: `${form.firstname} ${form.lastname}`
      }
      if(form.description){
        toSubmit.description = form.description;
      }
      addJha(toSubmit)
    }
  },
  data() {
    return {
      jha: jha,
    };
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-4/6 h-5/6">
      <!-- <input v-model="title" placeholder="Add Title" /> -->
      <Vueform :endpoint="false" ref="form$" @submit="sendJha" v-if="!jha">
        <!-- <StaticElement name="head">
          <div>Job</div>
        </StaticElement> -->
        <div class="font-bold text-2xl pt-2 pl-2 -mb-2">Job</div>
        <TextElement name="title" rules="required" class="px-2" />
        <GroupElement
        name="author"
        label="Author"
        :format-data="(n, v) =>(`${n} ${v}`)"
        class="px-2">
          <TextElement
            name="firstname"
            placeholder="First name"
            rules="required"
            class="w-full"
            columns="6"
          />
          <TextElement
            name="lastname"
            placeholder="Last name"
            rules="required"
            class="w-full"
            :columns="6"
          />
        </GroupElement>
        <TextareaElement
          label="Description"
          name="description"
          placeholder="Optional"
          class="px-2"
        />
        <ButtonElement v-if="!jha" class="mx-auto" name="submit" submits>
          Create JHA Form
        </ButtonElement>
      </Vueform>
      <div v-else>
        <div>{{ this.jha.title }}</div>
      </div>
      <!-- <button type="button" @click="sendJha">
        Create JHA form
      </button> -->
      <div v-if="jha" @click="close" id=jha ><AddSteps /></div>
    </div>
  </div>
</template>
