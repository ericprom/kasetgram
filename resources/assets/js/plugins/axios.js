import axios from 'axios'
import router from '../router'
import Store from '../store'
import swal from 'sweetalert2'

axios.interceptors.request.use(request => {
  if (Store.getters.authToken) {
    request.headers.common['Authorization'] = 'Bearer '+ Store.getters.authToken
  }
  return request
})

axios.interceptors.response.use(response => response, error => {
  const { status } = error.response
  if (status >= 500) {
    swal({
      type: error.response.data.type,
      title:  error.response.data.title,
      text:  error.response.data.text
    })
  }

  if (status === 401 && Store.getters.authCheck) {
    swal({
      type: 'warning',
      title: 'Session Expired!',
      text: 'Please log in again to continue.'
    })
    Store.dispatch('logout')
    router.push({ name: 'login' })
  }

  return Promise.reject(error)
})
