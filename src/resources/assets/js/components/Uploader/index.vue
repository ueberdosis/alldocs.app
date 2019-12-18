<template>
  <form
    class="c-uploader"
      :class="{
      'is-loading': isLoading,
      'is-drag-over': isDragOver,
      'is-finished': isFinished,
    }"
    :action="action"
    method="post"
    enctype="multipart/form-data"
    tabindex="0"
  >
    <input type="hidden" name="from" :value="from">
    <input type="hidden" name="to" :value="to">

    <div class="c-uploader__border"></div>

    <div class="c-uploader__content u-centered">
      <div v-if="isLoading">
        <div class="c-uploader__progress">
          Uploading… {{ progress }}%
        </div>
      </div>

      <div v-if="isFinished">
        <div class="grid" data-grid="narrow">
          <div class="grid__item">
            <a class="o-button" :href="file.download_url" download>
              Download {{ file.filename }}
            </a>
          </div>
          <div class="grid__item">
            <button class="o-button o-button--text" type="button" @click="reset">
              Upload Another File
            </button>
          </div>
        </div>
      </div>

      <div v-show="!isLoading && !isFinished">
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
      return !!this.file && !this.isLoading
    },
  },

  methods: {
    reset() {
      this.isLoading = false
      this.file = null
      this.progress = 0
      this.error = null
    },

    checkResponse() {
      if (this.file || this.error) {
        this.isLoading = false

        if (this.dropzone) {
          this.dropzone.removeAllFiles()
        }

        clearInterval(this.interval)
      }
    },
  },

  mounted() {
    Dropzone.autoDiscover = false

    this.dropzone = new Dropzone(this.$el, {
      acceptedFiles: this.acceptedFiles.join(','),
      maxFilesize: 10,
      maxFiles: 1,
      clickable: [this.$el, this.$refs.button],
      headers: {
        'X-CSRF-Token': window.app.csrfToken,
      },
    })

    this.dropzone
      .on('processing', () => {
        this.interval = setInterval(this.checkResponse, 1000)
        this.error = null
        this.isLoading = true
      })
      .on('totaluploadprogress', progress => {
        this.progress = progress
      })
      .on('success', (file, response) => {
        this.file = response
      })
      .on('error', (file, error) => {
        console.log({ error })
        this.error = error
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
  },

  beforeDestroy() {
    if (this.dropzone) {
      this.dropzone.destroy()
    }
  },
}
</script>

<style lang="scss" src="./style.scss"></style>
