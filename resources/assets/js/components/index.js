import Vue from 'vue'
import Child from './Child'
import DataViewer from './DataViewer'
import Datepicker from './Datepicker'
import MoneySummary from './MoneySummary'
import vSelect from 'vue-select'

Vue.component(Child.name, Child)
Vue.component(DataViewer.name, DataViewer)
Vue.component(Datepicker.name, Datepicker)
Vue.component(MoneySummary.name, MoneySummary)
Vue.component('v-select', vSelect)