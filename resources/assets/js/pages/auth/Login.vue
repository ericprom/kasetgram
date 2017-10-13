<template>
    <div class="panel panel-default">
        <div class="panel-heading">Login Component</div>

        <div class="panel-body">
            <div class="form-group">
                <label for="name">Email:</label>
                <input type="text" name="email" id="email" class="form-control" v-model="fields.email">
            </div>
            <div class="form-group">
                <label for="name">Password:</label>
                <input type="text" name="password" id="password" class="form-control" v-model="fields.password">
            </div>
            <button type="button" @click="login" class="btn btn-primary">Login</button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                fields: {
                    email: 'surasak@promrat.com',
                    password: '1q2w3e4r'
                },
                errors: []
            }
        },
        methods: {
            login()
            {
                Store.dispatch('login', this.fields)
                    .then(response => {
                        this.$router.replace(this.$route.query.redirect)
                        console.log('response from success login', response)
                    })
                    .catch(response => {
                        console.log('response from errors login', response)
                    });

            },
            reset()
            {
                this.fields.email = '';
                this.fields.password = '';
            },
        }
    }
</script>
