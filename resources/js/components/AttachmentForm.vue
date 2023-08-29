<template>
  <div class="success" style="margin-bottom: 10px" v-if="savingSuccessful">
    File <strong>{{ this.message.fileName }}</strong> has been successfully uploaded.<br>
    During uploading such records were found:<br>
    - number of <strong>correct</strong> records is {{ this.message.correctRecordCount }}.<br>
    - number of <strong>incorrect</strong> records is {{ this.message.incorrectRecordCount }}.
  </div>
  <form @submit.prevent="submit">
    <div class="form-group">
      <div class="custom-file">
        <input type="file"
               class="custom-file-input"
               id="customFile"
               @change="onAttachmentChange"
        >
      </div>
    </div>
    <div class="form-group" style="margin-top: 15px">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</template>

<script>
export default {
  data () {
    return {
      attachment: null,
      savingSuccessful: false,
      message: null
    }
  },
  methods: {
    submit () {
      const config = { 'content-type': 'multipart/form-data' }
      const formData = new FormData()
      formData.append('attachment', this.attachment)
      axios.post('/', formData, config)
        .then(response => {
          this.savingSuccessful = true
          this.message = response.data.message
        })
        .catch(error => console.log(error))
    },
    onAttachmentChange (e) {
      this.attachment = e.target.files[0]
    }
  }
}
</script>
