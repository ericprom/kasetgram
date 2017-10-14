<template>
    <div class="panel panel-default">
        <div class="panel-heading">Login Component</div>

        <div class="panel-body">
            <form @submit.prevent="login" @keydown="form.errors.clear($event.target.name)">
                <div class="form-group">
                  <label>{{ $t('email') }}</label>
                  <input v-model="form.email" type="text" name="email" required 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                </div>

                <div class="form-group">
                  <label>{{ $t('password') }}</label>
                  <input v-model="form.password" type="password" name="password" required
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                </div>

                <button :disabled="form.busy" type="submit" class="btn btn-primary">{{ $t('login') }}</button>
            </form>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import Form from 'vform'
    export default {
        data(){
            return {
                form: new Form({
                    email: 'surasak@promrat.com',
                    password: '1q2w3e4r'
                })
            }
        },
        methods: {
            login()
            {
                this.form.post('/api/v1/auth/login')
                    .then(({ data }) => { 

                        Store.dispatch('saveToken', data.success.access_token)

                        Store.dispatch('fetchUser').then(({ data }) =>{

                            if(this.$route.query.redirect){
                                this.$router.replace(this.$route.query.redirect)
                            }
                            else{
                                this.$router.push({ name: 'welcome' })
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
