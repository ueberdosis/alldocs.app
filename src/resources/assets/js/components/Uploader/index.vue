<template>
  <div
    class="c-uploader"
    :class="{
      'is-loading': isLoading,
      'is-drag-over': isDragOver,
      'is-finished': isFinished,
    }"
  >
    <form
      class="c-uploader__dropzone"
      :action="action"
      method="post"
      enctype="multipart/form-data"
      ref="dropzone"
      tabindex="0"
    >
      <input type="hidden" name="from" :value="from">
      <input type="hidden" name="to" :value="to">

      <div class="c-uploader__content u-centered">
        <div v-if="isLoading">
          <div class="c-uploader__progress">
            Uploading… {{ progress }}%
          </div>
        </div>

        <div v-else-if="isFinished">
          <div class="grid" data-grid="narrow">
            <div class="grid__item">
              <a class="o-button" href="#" download>
                Download myfile.xyz
              </a>
            </div>
            <div class="grid__item">
              <button class="o-button o-button--text" type="button" @click="reset">
                Upload Another File
              </button>
            </div>
          </div>
        </div>

        <div v-else>
          <div class="grid" data-grid="narrow">
            <div class="grid__item">
              <button class="o-button" type="button" ref="button">
                Drop or Browse File
              </button>
            </div>
            <div class="grid__item">
              <small>
                {{ acceptedFiles.join(' ') }}
              </small>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Dropzone from 'dropzone'

export default {
  props: {
    action: {
      required: true,
      type: String,
    },

    from: {
      required: true,
      type: String,
    },

    to: {
      required: true,
      type: String,
    },

    acceptedFiles: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      isDragOver: false,
      isLoading: false,
      progress: 0,
      error: null,
      file: null,
    }
  },

  computed: {
    isFinished() {
      return !!this.file
    },
  },

  methods: {
    reset() {
      this.isLoading = false
      this.file = null
      this.progress = 0
      this.error = null
    },
  },

  mounted() {
    Dropzone.autoDiscover = false

    const dropzone = new Dropzone(this.$refs.dropzone, {
      // acceptedFiles: 'image/*',
      acceptedFiles: this.acceptedFiles.join(','),
      maxFilesize: 10,
      maxFiles: 1,
      clickable: [this.$refs.dropzone, this.$refs.button],
      headers: {
        'X-CSRF-Token': window.app.csrfToken,
      },
    })

    dropzone
      .on('processing', () => {
        this.error = null
        this.isLoading = true
      })
      .on('totaluploadprogress', progress => {
        this.progress = progress
      })
      .on('success', (file, response) => {
        console.log({ response })
        this.file = true
        this.isLoading = false
        dropzone.removeAllFiles()
      })
      .on('error', (file, error) => {
        console.log({ error })
        this.error = error
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
