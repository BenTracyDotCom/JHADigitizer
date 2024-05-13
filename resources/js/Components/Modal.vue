<script>
import { ref } from "vue";
import axios from "axios";
import Step from "../Components/Step.vue";

export default {
  name: "Modal",
  components: {
    Step,
  },
  methods: {
    close() {
      this.$emit("close");
    },
    handleDelete() {
      this.disableEdit();
      this.$emit("deleteJha", this.id);
      this.$emit("close");
    },
    enableEdit() {
      this.editable = true
    },
    disableEdit() {
      this.editable = false
      this.$emit("finishEditing", this.formData);
      this.$emit("close");
    },
    finishedEditing() {
      this.$emit("finishEditing", this.formData)
    }
  },
  props: {
    id: Number,
    title: { type: String, default: "Title" },
    author: { type: String, default: "Author" },
    description: { type: String, default: null },
    created_at: { type: String, default: null },
    updated_at: { type: String, default: null },
    steps: { type: Array, default: [] }
  },
  data() {
    return {
      editable: false,
      formData: {
        id: this.id,
        title: this.title,
        author: this.author
      }
    };
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-5/6 h-5/6">
      <header class="p-[15px] flex relative border-b-2 justify-between">
        <slot name="header">
          <div class="flex flex-row">
            <div class="text-3xl font-bold"  v-if="!editable">
              {{ title }}
            </div>
            <div v-else>
              <input v-model="this.formData.title" />
            </div>
            <div v-if="editable">
              <img src="/images/edit.png" class="size-4 cursor-pointer"/>
            </div>
          </div>
          <div class="text-md">Created by {{ author }}</div>
        </slot>
        <button
          type="button"
          class="absolute top-0 right-0 text-xl font-bold p-2.5 bg-transparent text-red-500 cursor-pointer"
          @click="close"
        >
          x
        </button>
      </header>
      <section class="relative px-5 py-2.5">
        <slot name="body">
          <div class="grid grid-cols-3 border-b-2">
            <div>Steps</div>
            <div>Hazards</div>
            <div>Controls</div>
          </div>
          <div v-for="(step, index) in steps">
            <div class="border-b-2 border-x-2">
              <Step :key="index" :num="index" v-bind="step" :editable="editable" />
            </div>
          </div>
        </slot>
      </section>
      <footer class="p-[15px] flex border-t-2 flex-col justify-end">
        <slot name="footer"> Default Footer </slot>
        <button type="button" class="bg-slate-200 border-2 rounded-md" @click="enableEdit" v-if="!editable">
          Edit Job Hazard Analysis
        </button>
        <button type="button" class="bg-slate-200 border-2 rounded-md" @click="disableEdit" v-if="editable">
          Finish editing
        </button>
        <button type="button" class="bg-red-500 p-2" @click="handleDelete">Delete</button>
      </footer>
    </div>
  </div>
</template>
