<template>
  <form @submit.prevent="submit">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Name" v-model="name">
    </div>
    <div class="form-group">
      <div class="custom-file">
        <input type="file"
               class="custom-file-input"
               id="customFile"
               @change="onAttachmentChange"
        >
        <label class="custom-file-label" for="customFile">Choose file</label>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</template>

<script>
export default {
  data () {
    return {
      name: null,
      attachment: null
    }
  },
  methods: {
    submit () {
      const config = { 'content-type': 'multipart/form-data' }
      const formData = new FormData()
      formData.append('name', this.name)
      formData.append('attachment', this.attachment)

      axios.post('/', formData, config)
          .then(response => console.log(response.data.message))
          .catch(error => console.log(error))
    },
    onAttachmentChange (e) {
      this.attachment = e.target.files[0]
    }
  }
}
</script>
