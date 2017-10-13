<template>
	<div class="list-group">
        <router-link to="/" class="list-group-item">Home</router-link>
        <router-link to="/about" class="list-group-item">About</router-link>
        <router-link to="/login" class="list-group-item" v-if="!isLoggedIn">Login</router-link>
        <button @click="logout" class="list-group-item" v-if="isLoggedIn">Logout</button>
    </div>
</template>
<script>
    export default {
		computed: {
		    isLoggedIn () {
		      	return Store.state.isLoggedIn
		    }
		},
        methods: {
        	logout() {
                Store.dispatch('logout')
                    .then(response => {
                        this.$router.replace('/')
                        console.log('response from success logout', response)
                    })
                    .catch(response => {
                        console.log('response from errors logout', response)
                    });
            },
        }
    }
</script>