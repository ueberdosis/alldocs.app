<template>
  <div class="c-uploader">
    <form
      class="c-uploader__dropzone"
      :action="formAction"
      method="post"
      enctype="multipart/form-data"
      ref="dropzone"
      tabindex="0"
    />
  </div>
</template>

<script>
import Dropzone from 'dropzone'

export default {
  props: {
    formAction: {
      required: true,
      type: String,
    },
  },

  data() {
    return {
      isDragOver: false,
      isLoading: false,
      // defaults: {
      //   id: null,
      //   name: null,
      //   label: null,
      //   value: null,
      //   placeholder: 'Drop or Browse Files',
      //   errors: [],
      // },
    }
  },

  mounted() {
    Dropzone.autoDiscover = false

    const dropzone = new Dropzone(this.$refs.dropzone, {
      acceptedFiles: 'image/*',
      maxFilesize: 10,
      maxFiles: 1,
      headers: {
        // Authorization: axios.defaults.headers.common.Authorization,
      },
    })

    dropzone
      .on('processing', () => {
        // this.field.errors = []
        this.isLoading = true
      })
      .on('success', (file, response) => {
        // this.field.value = response.data
        console.log({ response })
        this.isLoading = false
        dropzone.removeAllFiles()
      })
      .on('error', (file, error) => {
        console.log({ error })
        // this.field.errors = [get(error, 'errors.file.0', error)]
        this.isLoading = false
        dropzone.removeAllFiles()
      })
      .on('dragover', () => {
        this.isDragOver = true
      })
      .on('dragleave', () => {
        this.isDragOver = false
      })
      .on('drop', () => {
        this.isDragOver = false
      })

    this.$once('hook:beforeDestroy', () => {
      dropzone.destroy()
    })
  },
}
</script>

<style lang="scss" src="./style.scss"></style>
