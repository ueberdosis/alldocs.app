import Vue from 'vue'
import Icon from './components/Icon'
import SelectFormat from './components/SelectFormat'

Vue.component('icon', Icon)
Vue.component('select-format', SelectFormat)

new Vue().$mount('#app')
