import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  companies: [],
  roles: [],
  menus: [],
  payments: [],
  expenses: [],
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

  [types.DATALIST_MENU] (state, menus) {
    state.menus = menus
  },

  [types.DATALIST_PAYMENT] (state, payments) {
    state.payments = payments
  },

  [types.DATALIST_EXPENSE] (state, expenses) {
    state.expenses = expenses
  },

  [types.DATALIST_ROLE] (state, roles) {
    state.roles = roles
  },

  [types.DATALIST_COMPANY] (state, companies) {
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
        axios.post('/api/v1/datalist/menus')
        .then(({ data }) =>{
          commit(types.DATALIST_MENU, data.menus)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

  createPayments ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/datalist/payments')
        .then(({ data }) =>{
          commit(types.DATALIST_PAYMENT, data.payments)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

  createExpenses ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/datalist/expenses')
        .then(({ data }) =>{
          commit(types.DATALIST_EXPENSE, data.expenses)
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
        axios.post('/api/v1/datalist/roles')
        .then(({ data }) =>{
          commit(types.DATALIST_ROLE, data.roles)
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
        axios.post('/api/v1/datalist/companies')
        .then(({ data }) =>{
          commit(types.DATALIST_COMPANY, data.companies)
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
  companies: state => state.companies,
  roles: state => state.roles,
  menus: state => state.menus,
  payments: state => state.payments,
  expenses: state => state.expenses,
  authUser: state => state.user,
  authToken: state => state.token,
  authCheck: state => state.user !== null
}
