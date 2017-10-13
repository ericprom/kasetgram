import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const state = {
    isLoggedIn: false,
    tokens: { },
    currentUser: { }
}

const getters = {
    isLoggedIn: state => state.isLoggedIn
}

const actions = {
    login(context, user) {
        return new Promise((resolve, reject) => {

            let data = {
                email: user.email,
                password: user.password,
            };

            axios.post('/api/v1/auth/login', data)
                .then(response => {

                    context.commit('updateStates', response.data.success)

                    resolve(response)
                })
                .catch(response => {
                    reject(response)
                })
        })
    },

    logout(context) {
        return new Promise((resolve, reject) => {

            axios.post('/api/v1/auth/logout')
                .then(response => {

                    context.commit('resetStates', response.data.success)

                    resolve(response)
                })
                .catch(response => {
                    reject(response)
                })
        })
    }
}

const mutations = {
    updateStates(state, data) {
        if(data.access_token){
            state.tokens.access_token = data.access_token 
            state.isLoggedIn = true;
        }
        if(data.current_user){
            state.currentUser = data.current_user 
        }
    },
    resetStates(state, data) {
        state.tokens = {};
        state.currentUser = {};
        state.isLoggedIn = false;
    },
}

let Store = new Vuex.Store({
    plugins: [createPersistedState()],
    getters: getters,
    state: state,
    actions: actions,
    mutations: mutations
})

export default Store