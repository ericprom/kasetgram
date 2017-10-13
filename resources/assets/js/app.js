require('./bootstrap');

import Vue from 'vue'
import VueRouter  from 'vue-router'
import router from './router'
import Store from './store'
import navbar from './components/Navbar.vue';

Vue.component('navbar', navbar);

window.Store = Store

Vue.use(VueRouter)

new Vue({

  router
 
}).$mount('#app')
