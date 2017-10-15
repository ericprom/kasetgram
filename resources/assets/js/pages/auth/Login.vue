<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('login')">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
            <div class="col-md-7">
              <input v-model="form.email" type="email" name="email" class="form-control"
                :class="{ 'is-invalid': form.errors.has('email') }">
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
            <div class="col-md-7">
              <input v-model="form.password" type="password" name="password" class="form-control"
                :class="{ 'is-invalid': form.errors.has('password') }">
            </div>
          </div>

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-3"></div>
            <div class="col-md-7">
              <router-link :to="{ name: 'password.request' }" class="float-right small">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy">{{ $t('login') }}</v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  layout: 'default',

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: 'surasak@promrat.com',
      password: '1q2w3e4r'
    }),
    remember: false
  }),

  methods: {
    login () {
      this.form.post('/api/v1/auth/login')
        .then(({ data }) => { 

          Store.dispatch('saveToken', data.success.access_token)

          Store.dispatch('fetchUser').then(({ data }) =>{

              if(this.$route.query.redirect){
                this.$router.replace(this.$route.query.redirect)
              }
              else{
                this.$router.push({ name: 'home' })
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
