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
  timers: [],
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

  [types.DATALIST_TIMER] (state, timers) {
    state.timers = timers
  },
}

// actions
export const actions = {


  
  createDatalist ({ dispatch }) {
    try {
      
        dispatch('createMenus')
        dispatch('createCompanies')
        dispatch('createRoles')
        dispatch('createPayments')
        dispatch('createExpenses')
        dispatch('createTypes')
        dispatch('createMakes')
        dispatch('createTimers')

    } catch (e) {}
  },

  createMenus ({ commit }) {
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

  createCompanies ({ commit }) {
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

  createRoles ({ commit }) {
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

  createPayments ({ commit }) {
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

  createExpenses ({ commit }) {
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

  createTypes ({ commit }) {
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

  createMakes ({ commit }) {
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

  createTimers ({ commit }) {
    try {
      var timers = [
        { id: 'yesterday', label: 'เมื่อวาน' },
        { id: 'today', label: 'วันนี้' },
        { id: 'this_month', label: 'เดือนนี้' },
        { id: 'last_month', label: 'เดือนที่แล้ว' },
        { id: 'next_month', label: 'เดือนหน้า' },
        { id: 'custom', label: 'ตั้งค่า' }
      ]
      commit(types.DATALIST_TIMER, timers)
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
  timers: state => state.timers,
}
