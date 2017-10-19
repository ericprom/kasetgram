export default ({ authGuard, guestGuard }) => [
  { path: '/', name: 'welcome', component: require('../pages/welcome.vue') },

  ...authGuard([
    { 
      path: '/dashboard', 
      name: 'dashboard', 
      component: require('../pages/dashboard')
    },
    { path: '/car-register', name: 'car-register', component: require('../pages/car/register') },
    { path: '/account', name: 'account', component: require('../pages/account') },
    { path: '/services', component: require('../pages/services/index.vue'), children: [
      { path: 'inspection', name: 'services.inspection', component: require('../pages/services/inspection.vue') },
      { path: 'insurance', name: 'services.insurance', component: require('../pages/services/insurance.vue') },
      { path: 'compulsory', name: 'services.compulsory', component: require('../pages/services/compulsory.vue') },
      { path: 'license', name: 'services.license', component: require('../pages/services/license.vue') },
    ] },
    { path: '/accountants', component: require('../pages/settings/index.vue'), children: [
      { path: 'ledger', name: 'accountants.ledger', component: require('../pages/accountants/ledger.vue') },
    ] },
    { path: '/reports', component: require('../pages/reports/index.vue'), children: [
      { path: 'income', name: 'reports.income', component: require('../pages/reports/income.vue') },
      { path: 'inspection', name: 'reports.inspection', component: require('../pages/reports/inspection.vue') },
      { path: 'insurance', name: 'reports.insurance', component: require('../pages/reports/insurance.vue') },
      { path: 'compulsory', name: 'reports.compulsory', component: require('../pages/reports/compulsory.vue') },
      { path: 'license', name: 'reports.license', component: require('../pages/reports/license.vue') },
      { path: 'expense', name: 'reports.expense', component: require('../pages/reports/expense.vue') },
    ] },
    { path: '/settings', component: require('../pages/settings/index.vue'), children: [
      { path: 'company', name: 'settings.company', component: require('../pages/settings/company.vue') },
      { path: 'employee', name: 'settings.employee', component: require('../pages/settings/employee.vue') },
      { path: 'payment', name: 'settings.payment', component: require('../pages/settings/payment.vue') },
      { path: 'car', name: 'settings.car', component: require('../pages/settings/car.vue') },
      { path: 'type', name: 'settings.type', component: require('../pages/settings/type.vue') },
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
