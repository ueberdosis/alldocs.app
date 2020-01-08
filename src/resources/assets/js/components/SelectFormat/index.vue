<template>
  <div class="c-select-format">
    <div class="c-select-format__title">
      <template v-if="selectedFormat">
        {{ selectedFormat.title }}
      </template>
      <template v-else>
        Select Format
      </template>
      <icon name="arrow-down" />
    </div>
    <select
      :name="name"
      :id="inputId"
      class="c-select-format__select"
      @change="onChange($event)"
      v-model="value"
    >
      <option value="">
        Select Format
      </option>
      <option
        v-for="format in formattedFormats"
        :key="format.name"
        :value="format.name"
      >
        {{ format.title }}
      </option>
    </select>
    <label class="u-visually-hidden" :for="inputId" v-if="label">
      {{ label }}
    </label>
  </div>
</template>

<script>
import collect from 'collect.js'
import serialize from 'form-serialize'
import uuid from 'uuid/v4'
import Icon from 'components/Icon'

export default {
  components: {
    Icon,
  },

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

    label: {
      default: null,
    },
  },

  data() {
    const selectedFormat = this.formats.find(format => format.name === this.selected)

    return {
      value: selectedFormat ? selectedFormat.name : null,
      inputId: `field-${uuid()}`,
    }
  },

  computed: {
    selectedFormat() {
      return this.formats.find(format => format.name === this.value)
    },

    formattedFormats() {
      return collect(this.formats)
        .sortBy(format => format.title.toUpperCase())
        .toArray()
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
