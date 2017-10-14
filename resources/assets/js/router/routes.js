import Welcome from '../pages/home/'

export default ({ authGuard, guestGuard }) => [
  { path: '/', name: 'welcome', component: Welcome }
]
