import Vue from 'vue'
import Child from './Child'
import DataViewer from './DataViewer'
import vSelect from "vue-select"

Vue.component(Child.name, Child)
Vue.component(DataViewer.name, DataViewer)
Vue.component('v-select', vSelect)