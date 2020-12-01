<template>
  <div>
    <upload-file
      v-if="! isFileUploaded"
      :upload-error="uploadError"
      v-on:uploadFile="processFileUpload"
    ></upload-file>
    <map-fields
      v-else-if="! isMappingDone"
      :file-name="fileName"
      :rows-count="rowsCount"
      :columns-map="columnsMap"
      :csv-headers="csvHeaders"
      :mappings-error="mappingsError"
      v-on:mappingsSaved="processMappings"
    ></map-fields>
    <contacts-list
      :contacts="contacts"
      v-if="isFileUploaded && isMappingDone"
    ></contacts-list>
  </div>
</template>
<script>
import MapFields from '../components/MapFields.vue';
import UploadFile from '../components/UploadFile.vue';
import ContactsList from '../components/ContactsList.vue';

export default {
  props: [
    'columnsMap',
    'apiRoutes',
  ],

  components: {
    UploadFile,
    MapFields,
    ContactsList
  },

  data() {
    return {
      isFileUploaded: false,
      isMappingDone: false,
      rowsCount: 0,
      uploadError: '',
      mappingsError: '',
      fileName: '',
      filePath: '',
      csvHeaders: [],
      contacts: [],
    }
  },

  methods: {
    processFileUpload(file) {
      // Clean up the error
      this.uploadError = '';

      // Usual code for file uploads
      let formData = new FormData();
      formData.append('file', file);

      // Upload the file
      axios.post(
        this.apiRoutes.processFile,
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then((response) => {
        if (! response.data.valid) {
          // Display the returned error
          this.uploadError = response.data.error;
          return;
        }

        // Update data for the mapping component
        this.rowsCount      = response.data.count;
        this.fileName       = response.data.name;
        this.csvHeaders     = response.data.headers;
        this.filePath       = response.data.path;
        this.isFileUploaded = true;
      })
      .catch((error) => {
        this.uploadError = error.response.data.errors.file[0] ||
          'Something went wrong with the upload, please do try again';
      });
    },

    processMappings(mappings) {
        this.mappingsError = '';
        
        axios.post(
          this.apiRoutes.processMappings,
          {
            mappings,
            path: this.filePath,
          }
        ).then((response) => {
          this.contacts = response.data.contacts;
          this.isMappingDone = true;
        })
        .catch((error) => {
          if (typeof error.response.data.errors.path !== 'undefined') {
            this.mappingsError = error.response.data.errors.path[0];
          } else if (typeof error.response.data.errors.mappings !== 'undefined') {
            this.mappingsError = error.response.data.errors.mappings[0];
          } else {
            this.mappingsError = 'Something went wrong while processing the mappings, please try again';
          }
        });
    }
  }
  
};
</script>