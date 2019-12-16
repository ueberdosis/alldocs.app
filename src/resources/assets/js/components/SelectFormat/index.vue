<template>
  <div class="c-select-format">
    <div class="c-select-format__title">
      {{ selectedFormat.title }}
    </div>
    <select :name="name" class="c-select-format__select" @change="onChange($event)" v-model="value">
      <option
        v-for="format in formats"
        :key="format.name"
        :value="format.name"
      >
        {{ format.title }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  props: {
    formats: {
      default: () => [],
    },

    selectedFormat: {
      default: null,
    },

    name: {
      default: null,
    },
  },

  data() {
    return {
      value: this.selectedFormat.name,
    }
  },

  methods: {
    onChange() {
      const form = this.$el.closest('form')

      if (form) {
        form.submit()
      }
    },
  },
}
</script>

<style lang="scss" src="./style.scss"></style>
