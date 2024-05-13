<script>
import axios from "axios";
import { ref } from "vue";

const control = ref(null);

async function postControl({ hazard_id, title }) {
  const toSend = {
    hazard_id: hazard_id,
    title: title,
  };

  const { data } = await axios.post(
    `${import.meta.env.VITE_APP_URL}/api/controls`,
    toSend
  );
  control.value = data;
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
      console.log('sending?')
      const form = this.$refs.form$.data;
      form.hazard_id = this.id;
      postControl(form);
      this.hasSaved = true;
      this.title = form.title
    },
  },
};
</script>

<template>
  <div>
    <Vueform :endpoint="false" ref="form$" @submit="sendControl" v-if="!this.hasSaved">
      <GroupElement name="control">
        <TextElement name="title" placeholder="Control" rules="required" />
      </GroupElement>
      <ButtonElement v-if="!hasSaved" name="submit" submits> Save </ButtonElement>
    </Vueform>
    <div v-else>{{ this.title }}</div>
  </div>
</template>
