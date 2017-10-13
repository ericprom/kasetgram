import VueRouter from 'vue-router'

import Home from '../pages/home'
import About from '../pages/about'
import Login from '../pages/auth/Login.vue'

var routes = [
	{ 
		path: '/', 
		name: 'welcome', 
		component: Home
	},
    { 
    	path: '/about', 
    	name: 'about', 
    	component: About, 
    	meta: { 
    		requiresAuth: true 
    	}  
    },
    { 
    	path: '/login', 
    	name: 'login', 
    	component: Login,
    	meta: { 
    		requiresGuest: true 
    	}  
    }
];

var router = new VueRouter({
	mode: 'history',
  	base: __dirname,
  	routes
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) && !Store.getters.isLoggedIn) {
   	next({ name: 'login', query: { redirect: to.fullPath } })
  }
  else if (to.matched.some(record => record.meta.requiresGuest) && Store.getters.isLoggedIn) {
   	next({ name: 'welcome' })
  } else {
    next();
  }
});

export default router
