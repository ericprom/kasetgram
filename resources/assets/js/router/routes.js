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
    { path: '/account', name: 'account', component: require('../pages/account') },
    { path: '/settings', component: require('../pages/settings/index.vue'), children: [
      { path: 'company', name: 'settings.company', component: require('../pages/settings/company.vue') },
      { path: 'employee', name: 'settings.employee', component: require('../pages/settings/employee.vue') },
      { path: 'payment', name: 'settings.payment', component: require('../pages/settings/payment.vue') },
      { path: 'car', name: 'settings.car', component: require('../pages/settings/car.vue') },
      { path: 'type', name: 'settings.type', component: require('../pages/settings/type.vue') },
      { path: 'service', name: 'settings.service', component: require('../pages/settings/service.vue') },
      { path: 'insurance', name: 'settings.insurance', component: require('../pages/settings/insurance.vue') },
      { path: 'code', name: 'settings.code', component: require('../pages/settings/code.vue') },
      { path: 'expense', name: 'settings.expense', component: require('../pages/settings/expense.vue') },
    ] },
    { path: '/systems', component: require('../pages/systems/index.vue'), children: [
      { path: 'company', name: 'systems.company', component: require('../pages/systems/company.vue') },
      { path: 'role', name: 'systems.role', component: require('../pages/systems/role.vue') },
      { path: 'permission', name: 'systems.permission', component: require('../pages/systems/permission.vue') },
      { path: 'user', name: 'systems.user', component: require('../pages/systems/user.vue') },
    ] }
  ]),

  ...guestGuard([
    { path: '/login', name: 'login', component: require('../pages/auth/login.vue') },
    { path: '/password/reset', name: 'password.request', component: require('../pages/auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: require('../pages/auth/password/reset.vue') }
  ]),

  { path: '*', component: require('../pages/errors/404.vue') }
]
