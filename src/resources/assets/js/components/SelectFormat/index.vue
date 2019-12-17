<template>
  <div class="c-select-format">
    <div class="c-select-format__title">
      <template v-if="selectedFormat">
        {{ selectedFormat.title }}
      </template>
      <template v-else>
        Select Format
      </template>
    </div>
    <select :name="name" class="c-select-format__select" @change="onChange($event)" v-model="value">
      <option value="">
        Select Format
      </option>
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
import serialize from 'form-serialize'

export default {
  props: {
    formats: {
      default: () => [],
    },

    selected: {
      default: null,
    },

    name: {
      default: null,
    },
  },

  data() {
    const selectedFormat = this.formats.find(format => format.name === this.selected)

    return {
      value: selectedFormat ? selectedFormat.name : null,
    }
  },

  computed: {
    selectedFormat() {
      return this.formats.find(format => format.name === this.value)
    },
  },

  methods: {
    onChange() {
      const form = this.$el.closest('form')

      if (form) {
        const data = serialize(form, { hash: true, empty: true })
        const someInputIsEmpty = Object.entries(data).some(([, value]) => value === '')

        if (!someInputIsEmpty) {
          form.submit()
        }
      }
    },
  },
}
</script>

<style lang="scss" src="./style.scss"></style>
