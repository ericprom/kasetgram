require('./bootstrap');

import Vue from 'vue'
import router from './router'
import { i18n } from './plugins'
import App from './components/App'
import Store from './store'
import './components'
import './utils'

Vue.config.productionTip = false
window.Store = Store

new Vue({
	
	i18n,
  	router,
  	...App
 
})
