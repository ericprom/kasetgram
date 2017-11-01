export default ({ authGuard, guestGuard }) => [
  { path: '/', component: require('../pages/auth/login.vue') },

  ...authGuard([
    { path: '/dashboard', name: 'dashboard', component: require('../pages/dashboard')},
    { path: '/planting', name: 'planting', component: require('../pages/planting')},
    { path: '/account', name: 'account', component: require('../pages/account') },
    { path: '/reports', component: require('../pages/reports/index.vue'), children: [
      { path: 'income', name: 'reports.income', component: require('../pages/reports/income.vue') },
      { path: 'expense', name: 'reports.expense', component: require('../pages/reports/expense.vue') },
    ] },
    { path: '/accountants', component: require('../pages/settings/index.vue'), children: [
      { path: 'income', name: 'accountants.income', component: require('../pages/accountants/income.vue') },
      { path: 'expense', name: 'accountants.expense', component: require('../pages/accountants/expense.vue') },
    ] },
    { path: '/settings', component: require('../pages/settings/index.vue'), children: [
      { path: 'company', name: 'settings.company', component: require('../pages/settings/company.vue') },
      { path: 'employee', name: 'settings.employee', component: require('../pages/settings/employee.vue') },
      { path: 'farm', name: 'settings.farm', component: require('../pages/settings/farm.vue') },
      { path: 'plan', name: 'settings.plan', component: require('../pages/settings/plan.vue') }
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
