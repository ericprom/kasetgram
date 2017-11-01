<template>
  <div class="login-box">
    <div class="login-logo">
        {{ title }}
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">ระบบจัดการเกษตรอัจฉริยะ</p>
       <form @submit.prevent="login" @keydown="form.onKeydown($event)">
        <div class="form-group has-feedback">
          <input v-model="form.email" type="email" name="email" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }">
          <span class="fa fa-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input v-model="form.password" type="password" name="password" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" 
              :disabled="form.busy">เข้าสู่ระบบ
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2'
import Form from 'vform'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'เข้าสู่ระบบ' }
  },

  data() {
    return {
      title: window.config.appName,
      form: new Form({
        email: '',
        password: ''
      }),
      remember: false
    }
  },

  mount(){
    if(Store.getters.authCheck){
      this.$router.push({ name: 'dashboard' })
    }
  },

  methods: {
    login () {
      this.form.post('/api/v1/auth/login')
        .then(({ data }) => {
          Store.dispatch('saveToken', data.token)

          Store.dispatch('fetchUser').then(({ data }) =>{

            if(this.$route.query.redirect){
              this.$router.replace(this.$route.query.redirect)
            }
            else{
              this.$router.push({ name: 'dashboard' })
            }

          })
        })
    }
  }
}
</script>
