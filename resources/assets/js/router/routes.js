export default ({ authGuard, guestGuard }) => [
  { path: '/', name: 'welcome', component: require('../pages/welcome.vue') },

  ...authGuard([
    { 
      path: '/dashboard', 
      name: 'dashboard', 
      component: require('../pages/dashboard')
    },
    { path: '/car-register', name: 'car-register', component: require('../pages/car/register') },
    { path: '/customers', name: 'customers', component: require('../pages/customers') },
    { path: '/settings', component: require('../pages/settings/index.vue'), children: [
      { path: 'company', name: 'settings.company', component: require('../pages/settings/company.vue') },
      { path: 'employee', name: 'settings.employee', component: require('../pages/settings/employee.vue') },
      { path: 'car', name: 'settings.car', component: require('../pages/settings/car.vue') },
      { path: 'payment', name: 'settings.payment', component: require('../pages/settings/payment.vue') },
      { path: 'service', name: 'settings.service', component: require('../pages/settings/service.vue') },
    ] }
  ]),

  ...guestGuard([
    { path: '/login', name: 'login', component: require('../pages/auth/login.vue') },
    { path: '/password/reset', name: 'password.request', component: require('../pages/auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: require('../pages/auth/password/reset.vue') }
  ]),

  { path: '*', component: require('../pages/errors/404.vue') }
]
