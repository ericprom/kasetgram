import Vue from 'vue'
import Meta from 'vue-meta'
import Store from '../store'
import routes from './routes'
import Router from 'vue-router'
import { sync } from 'vuex-router-sync'

Vue.use(Meta)
Vue.use(Router)

const router = make(
  routes({ authGuard, guestGuard })
)

sync(Store, router)

export default router

function make (routes) {
  const router = new Router({
    routes,
    scrollBehavior,
    mode: 'history'
  })

  router.beforeEach((to, from, next) => {
    if (!Store.getters.authCheck && Store.getters.authToken) {
      try {
        Store.dispatch('fetchUser')
      } catch (e) { }
    }

    setLayout(router, to)
    next()
  })

  router.afterEach((to, from) => {
    router.app.$nextTick(() => {
      router.app.$loading.finish()
    })
  })

  return router
}

function setLayout (router, to) {
  const [component] = router.getMatchedComponents({ ...to })

  if (component) {
    router.app.$nextTick(() => {

      if (component.loading !== false) {
        router.app.$loading.start()
      }

      router.app.setLayout(component.layout || '')
    })
  }
}

function authGuard (routes) {
  return beforeEnter(routes, (to, from, next) => {
    if (!Store.getters.authCheck) {
      next({ name: 'login' })
    } else {
      next()
    }
  })
}

function guestGuard (routes) {
  return beforeEnter(routes, (to, from, next) => {
    if (Store.getters.authCheck) {
      next({ name: 'home' })
    } else {
      next()
    }
  })
}

function beforeEnter (routes, beforeEnter) {
  return routes.map(route => {
    return { ...route, beforeEnter }
  })
}

function scrollBehavior (to, from, savedPosition) {
  if (savedPosition) {
    return savedPosition
  }

  const position = {}

  if (to.hash) {
    position.selector = to.hash
  }

  if (to.matched.some(m => m.meta.scrollToTop)) {
    position.x = 0
    position.y = 0
  }

  return position
}
