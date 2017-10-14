<template>
	<div class="list-group">
        <router-link to="/" class="list-group-item" v-if="authenticated">{{ user.name }}</router-link>
        <router-link to="/" class="list-group-item">Home</router-link>
        <router-link to="/about" class="list-group-item">About</router-link>
        <router-link to="/login" class="list-group-item" v-if="!authenticated">Login</router-link>
        <button @click="logout" class="list-group-item" v-if="authenticated">Logout</button>
    </div>
</template>
<script>
    export default {
		computed: {
            user () {
                return Store.getters.authUser
            },
            authenticated () {
                return Store.getters.authCheck
            }
        },
        methods: {
        	logout() {
                Store.dispatch('logout')
                this.$router.push({ name: 'login' })
            },
        }
    }
</script>