<script>
export default {
  name: 'Jha',
  methods: {
    close() {
      this.$emit('close');
    },
  },
};
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex justify-center items-center">
    <div class="shadow-lg overflow-y-auto flex flex-col bg-white rounded-lg w-4/6 h-5/6">
      <header class="p-[15px] flex relative border-b-2 justify-between">
        <slot name="header">
          Default Header
        </slot>
        <button type="button" class="absolute top-0 right-0 text-xl font-bold p-2.5 bg-transparent text-teal-300 cursor-pointer" @click="close">
          x
        </button>
      </header>
      <section class="relative px-5 py-2.5">
        <slot name="body">
          Default Body
        </slot>
      </section>
      <footer class="p-[15px] flex border-t-2 flex-col justify-end">
        <slot name="footer">
          Default Footer
        </slot>
        <button
            type="button"
            class="bg-green-300 border-2 rounded-md"
            @click="close"
          >
            Close Modal
          </button>
      </footer>
    </div>
  </div>
</template>