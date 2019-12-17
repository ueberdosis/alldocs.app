import Vue from 'vue'
import Icon from './components/Icon'
import Uploader from './components/Uploader'
import SelectFormat from './components/SelectFormat'

Vue.component('icon', Icon)
Vue.component('uploader', Uploader)
Vue.component('select-format', SelectFormat)

new Vue().$mount('#app')
