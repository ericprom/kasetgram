require('./bootstrap');

import Vue from 'vue'
import router from './router'
import { i18n } from './plugins'
import Store from './store'
import App from './components/App'
import Vuetify from 'vuetify'

import './components'

Vue.use(Vuetify)
Vue.config.productionTip = false
window.Store = Store

new Vue({
	
	i18n,
  	router,
  	...App
 
})
