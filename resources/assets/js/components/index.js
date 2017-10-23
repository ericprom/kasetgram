import Vue from 'vue'

import vSelect from 'vue-select'
Vue.component('v-select', vSelect)

import VueChart from 'vue-chart-js'
Vue.component('vue-chart', VueChart)

const requireContext = require.context('./modules', false, /.*\.vue$/)
const modules = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((modules, [name, module]) => {
    modules[name] = module
    return modules
  }, {})

Object.keys(modules).forEach(function(key) {
  Vue.component(modules[key]['name'], modules[key])
});