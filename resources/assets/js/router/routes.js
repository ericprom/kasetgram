export default ({ authGuard, guestGuard }) => [
  { path: '/', name: 'welcome', component: require('../pages/home.vue') },

  ...authGuard([
    { path: '/home', name: 'home', component: require('../pages/home.vue') },
    { path: '/about', name: 'about', component: require('../pages/about') },
    { path: '/settings', component: require('../pages/settings/index.vue'), children: [
      { path: '', redirect: { name: 'settings.profile' }},
      { path: 'profile', name: 'settings.profile', component: require('../pages/settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: require('../pages/settings/password.vue') }
    ] }
  ]),

  ...guestGuard([
    { path: '/login', name: 'login', component: require('../pages/auth/login.vue') }
  ]),

  { path: '*', component: require('../pages/errors/404.vue') }
]
