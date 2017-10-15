<template>
  <div class="login-box">
    <div class="login-logo">
        {{ title }}
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">เข้าสู่ระบบจัดการ ตรอ.</p>
       <form @submit.prevent="login" @keydown="user.onKeydown($event)">
        <div class="form-group has-feedback">
          <input v-model="user.email" type="email" name="email" class="form-control"
                  :class="{ 'is-invalid': user.errors.has('email') }">
          <span class="fa fa-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input v-model="user.password" type="password" name="password" class="form-control"
                  :class="{ 'is-invalid': user.errors.has('password') }">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" 
              :disabled="user.busy">เข้าสู่ระบบ
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'เข้าสู่ระบบ' }
  },

  data: () => ({
    title: window.config.appName,
    user: new Form({
      email: 'surasak@promrat.com',
      password: '1q2w3e4r'
    }),
    remember: false
  }),

  methods: {
    login () {
      this.user.post('/api/v1/auth/login')
        .then(({ data }) => { 

          Store.dispatch('saveToken', data.success.access_token)

          Store.dispatch('fetchUser').then(({ data }) =>{

              if(this.$route.query.redirect){
                this.$router.replace(this.$route.query.redirect)
              }
              else{
                this.$router.push({ name: 'dashboard' })
              }

          })
        })
        .catch(({ data }) =>{
          console.log(data)
        })
    }
  }
}
</script>
