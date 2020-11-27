<template>
  <upload-file
    v-if="! isFileUploaded"
    v-on:uploadFile="processFileUpload"
  ></upload-file>
  <map-fields
    v-else-if="! isMappingDone"
  ></map-fields>
</template>
<script>
import MapFields from '../components/MapFields.vue';
import UploadFile from '../components/UploadFile.vue';

export default {
  props: [
    'columnsMap',
    'apiRoutes',
  ],

  components: {
    UploadFile,
    MapFields
  },

  data() {
    return {
      isFileUploaded: false,
      isMappingDone: false,
      fileName: '',
    }
  },

  methods: {
    processFileUpload(file) {
      let formData = new FormData();
      formData.append('file', file);

      axios.post(
        this.apiRoutes.processFile,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then(() => {
        
      })
      .catch(() => {

      });
    }
  }
  
};
</script>