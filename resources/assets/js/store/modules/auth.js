import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  companies: [],
  roles: [],
  menus: [],
  user: null,
  token: Cookies.get('token')
}

// mutations
export const mutations = {
  [types.SAVE_TOKEN] (state, token) {
    state.token = token
    Cookies.set('token', token)
  },

  [types.FETCH_USER_SUCCESS] (state, user) {
    state.user = user
  },

  [types.FETCH_USER_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.LOGOUT] (state) {
    state.user = null
    state.token = null

    Cookies.remove('token')
  },

  [types.UPDATE_USER] (state, user) {
    state.user = user
  },

  [types.USER_MENU] (state, menus) {
    state.menus = menus
  },

  [types.USER_ROLE] (state, roles) {
    state.roles = roles
  },

  [types.USER_COMPANY] (state, companies) {
    state.companies = companies
  }
}

// actions
export const actions = {

  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  createMenus ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/auth/menus')
        .then(({ data }) =>{
          commit(types.USER_MENU, data.menus)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

  createRoles ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/auth/roles')
        .then(({ data }) =>{
          commit(types.USER_ROLE, data.roles)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

  createCompanies ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/auth/companies')
        .then(({ data }) =>{
          commit(types.USER_COMPANY, data.companies)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

  fetchUser ({ commit }, payload) {

    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/auth/profile/details')
        .then(({ data }) =>{
          commit(types.FETCH_USER_SUCCESS, data.user)
          resolve(data)
        })
        .catch(function (error) {
          commit(types.FETCH_USER_FAILURE)
          reject(error)
        })
      })

    } catch (e) {
      commit(types.FETCH_USER_FAILURE)
    }
  },

  updateUser ({ commit }, payload) {
    commit(types.UPDATE_USER, payload)
  },

  logout ({ commit }) {
    try {
      axios.post('/api/v1/auth/logout')
    } catch (e) { }

    commit(types.LOGOUT)
  }
}

// getters
export const getters = {
  authCompanies: state => state.companies,
  authRoles: state => state.roles,
  authMenus: state => state.menus,
  authUser: state => state.user,
  authToken: state => state.token,
  authCheck: state => state.user !== null
}
