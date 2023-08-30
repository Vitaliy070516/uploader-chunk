<template>
  <div class="success" style="margin-bottom: 10px" v-if="savingAllSuccessful">
    File <strong>{{ this.message.fileName }}</strong> has been successfully uploaded.<br>
    During uploading such records were found:<br>
    - number of <strong>correct</strong> records is {{ this.message.correctRecordCount }}.<br>
    - number of <strong>incorrect</strong> records is {{ this.message.incorrectRecordCount }}.
  </div>
  <div>
    <input type="file" @change="select">
    <progress :value="progress"></progress>
  </div>
</template>

<script>
export default {
  watch: {
    chunks: {
      deep: true,
      handler(newValue) {
        if (newValue.length > 0) {
          this.upload();
        }
      }
    }
  },

  data() {
    return {
      file: null,
      chunks: [],
      uploaded: 0,
      uid: null,
      savingAllSuccessful: false,
      message: null
    };
  },

  computed: {
    progress() {
      if (this.file !== null) {
        return Math.floor((this.uploaded * 100) / this.file.size);
      }
    },
    formData() {
      let formData = new FormData;
      formData.set('is_last', this.chunks.length === 1);
      formData.set('uid', this.uid);
      formData.set('file', this.chunks[0], `${this.file.name}.part`);
      return formData;
    },
    config() {
      return {
        method: 'POST',
        data: this.formData,
        url: '/',
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: event => {
          this.uploaded += event.loaded;
        }
      };
    }
  },

  methods: {
    select(event) {
      this.file = event.target.files.item(0);
      this.createChunks(this.chunks);
      this.uid = Date.now();
    },
    createChunks(chunks) {
      let fileReader = new FileReader();
      fileReader.onload = function(event) {
        const chunkSize = 1000;
        const rows = event.target.result.split('\n');
        for (let i = 0; i < rows.length; i += chunkSize) {
          let chunk = rows.slice(i, i + chunkSize);
          let blob = new Blob([chunk.join('\n')], {type: 'text/csv;charset=utf-8;'});
          chunks.push(blob);
        }
      }
      fileReader.readAsText(this.file);
    },
    upload() {
      axios(this.config)
        .then(response => {
          this.chunks.shift();
          if (response.data.message !== 'undefined' && response.data.message.savingAllSuccessful) {
            this.savingAllSuccessful = true;
            this.message = response.data.message;
          }
        })
        .catch(error => console.log(error));
    }
  }
}
</script>
