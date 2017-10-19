import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  menus: [],
  companies: [],
  roles: [],
  payments: [],
  expenses: [],
  types: [],
  makes: [],
}

// mutations
export const mutations = {
  
  [types.DATALIST_MENU] (state, menus) {
    state.menus = menus
  },

  [types.DATALIST_COMPANY] (state, companies) {
    state.companies = companies
  },

  [types.DATALIST_ROLE] (state, roles) {
    state.roles = roles
  },

  [types.DATALIST_PAYMENT] (state, payments) {
    state.payments = payments
  },

  [types.DATALIST_EXPENSE] (state, expenses) {
    state.expenses = expenses
  },
  
  [types.DATALIST_TYPE] (state, types) {
    state.types = types
  },

  [types.DATALIST_MAKE] (state, makes) {
    state.makes = makes
  },
}

// actions
export const actions = {
  
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

  createTypes ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/datalist/types')
        .then(({ data }) =>{
          commit(types.DATALIST_TYPE, data.types)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

  createMakes ({ commit }, payload) {
    try {
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/datalist/makes')
        .then(({ data }) =>{
          commit(types.DATALIST_MAKE, data.makes)
          resolve(data)
        })
        .catch(function (error) {
            reject(error)
        })
      })

    } catch (e) {}
  },

}

// getters
export const getters = {
  menus: state => state.menus,
  companies: state => state.companies,
  roles: state => state.roles,
  payments: state => state.payments,
  expenses: state => state.expenses,
  types: state => state.types,
  makes: state => state.makes,
}
