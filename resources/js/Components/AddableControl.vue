<script>
import axios from "axios";
import { ref } from "vue";

const control = ref(null);

async function postHazard({ hazard_id, title }) {
  const toSend = {
    hazard_id: hazard_id,
    title: title,
  };

  const { data } = await axios.post(
    `${import.meta.env.VITE_APP_URL}/api/controls`,
    toSend
  );
  hazard.value = data;
}
export default {
  name: "AddableControl",
  props: {
    id: Number,
  },
  data() {
    return {
      control: control,
      hasSaved: false,
      title: ''
    };
  },
  methods: {
    sendControl() {
      const form = this.$refs.form$.data;
      form.hazard_id = this.id;
      postHazard(form);
      this.hasSaved = true;
      this.title = form.title
    },
    handleAddControl() {
      this.controls[this.controls.length] = this.controls.length + 1;
    },
  },
};
</script>

<template>
  <div>
    <Vueform :endpoint="false" ref="form$" @submit="sendHazard" v-if="!this.hasSaved">
      <GroupElement name="control">
        <TextElement name="title" placeholder="Control" rules="required" />
      </GroupElement>
      <ButtonElement v-if="!haSaved" name="submit" submits> Save </ButtonElement>
    </Vueform>
    <div v-else>{{ this.title }}</div>
  </div>
</template>
