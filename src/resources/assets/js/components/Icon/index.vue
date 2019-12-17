<script>
export default {
  name: 'Icon',

  props: {
    name: {
      type: String,
      default: '',
    },

    size: {
      type: String,
      default: 'normal',
    },
  },

  render(createElement) {
    let svgHTML = ''
    try {
      svgHTML = require(`!html-loader!images/icons/${this.name}.svg`)
    } catch (e) {
      // eslint-disable-next-line
      console.warn(`Unable to load "${this.name}.svg" icon. Verify it exists in the icons directory.`, e)
    }
    return createElement(
      'div',
      {
        class: `c-icon c-icon--${this.size}`,
        domProps: {
          innerHTML: svgHTML,
        },
      },
    )
  },
}
</script>

<style lang="scss" src="./style.scss"></style>
