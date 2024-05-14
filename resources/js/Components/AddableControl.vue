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
  return data
}

async function deleteControl(id) {
  const { data } = await axios.delete(
    `${import.meta.env.VITE_APP_URL}/api/controls/${id}`
  )
  return data
}
export default {
  name: "AddableControl",
  props: {
    id: Number,
    index: Number,
    present: Boolean,
    control
  },
  data() {
    return {
      hasSaved: false,
      title: "",
    };
  },
  methods: {
    sendControl() {
      const form = this.$refs.form$.data;
      form.hazard_id = this.id;
      postControl(form)
      .then(data => {
        this.$emit('controlSaved', { data, index:this.index})
        this.hasSaved = true;
        this.title = form.title;
      })
    },
    handleDelete() {
      if(this.hasSaved){
        deleteControl(this.control.id)
      }
      this.$emit('deleteControl', this.control)
    }
  },
};
</script>

<template>
  <div>
    <Vueform :endpoint="false" ref="form$" @submit="sendControl" v-if="!this.hasSaved">
      <GroupElement name="control">
        <TextElement name="title" placeholder="Control" rules="required" />
      </GroupElement>
      <div>
        <ButtonElement v-if="!hasSaved" name="submit" submits class="invisible">
        </ButtonElement>
      </div>
    </Vueform>
      <div class="flex flex-row justify-around -mt-8" v-if="!this.hasSaved && !this.present">
        <div class="cursor-pointer bg-green-500 w-4 rounded-full" @click="handleDelete">
          <img src="/images/minus-button.png"/>
        </div>
        <div class="cursor-pointer bg-green-500 w-4 rounded-full" @click="sendControl">
          <img src="/images/accept.png"/>
        </div>
      </div>
    <div v-else class="flex flex-row">
      <div>{{ this.present ? this.control.title : this.title }}</div>
      <div @click="handleDelete" class="text-red-500 cursor-pointer">x</div>
    </div>
  </div>
</template>
