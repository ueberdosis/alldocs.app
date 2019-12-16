module.exports = {
  plugins: ['html'],

  parserOptions: {
    parser: 'babel-eslint',
    sourceType: 'module',
  },

  env: {
    es6: true,
    node: true,
  },

  globals: {
    document: false,
    navigator: false,
    window: false,
    Echo: false,
    $: false,
    jQuery: false,
    collect: false,
    cy: false,
    it: false,
    describe: false,
    FileReader: false,
    atob: false,
    requestAnimationFrame: false,
    cancelAnimationFrame: false,
  },

  extends: [
    'plugin:vue/base',
    'airbnb-base',
  ],

  rules: {
    // required semicolons
    'semi': ['error', 'never'],

    // disable some import stuff
    'import/extensions': 'off',
    'import/no-extraneous-dependencies': 'off',
    'import/no-unresolved': 'off',
    'import/no-dynamic-require': 'off',

    // disable for '__svg__'
    'no-underscore-dangle': 'off',

    'arrow-parens': ['error', 'as-needed'],

    'padded-blocks': 'off',

    'class-methods-use-this': 'off',

    'global-require': 'off',

    'func-names': ['error', 'never'],
  }
}
