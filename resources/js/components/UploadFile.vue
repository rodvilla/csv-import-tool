<template>
  <div class="border-4 border-dashed border-gray-200 rounded-lg">
    <label class="block w-full px-4 py-16 flex flex-col items-center bg-white hover:bg-gray-100 cursor-pointer">
      <svg class="w-16 h-16 m-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
      </svg>
      <span class="font-bold text-lg">Upload CSV File</span>
      <input type="file" class="hidden" ref="file" v-on:change="uploadFile()" />
    </label>
  </div>

</template>
<script>
export default {
  props: [
    'route'
  ],

  data() {
    return {
      uploadError: '',
      file: null,
    }
  },

  methods: {
    uploadFile() {
      this.$emit('uploadFile', this.$refs.file.files[0])
    }
  }
};
</script>