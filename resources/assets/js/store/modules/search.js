import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  query: "",
}

// mutations
export const mutations = {
  [types.QUERY_STRING] (state, string) {
    state.query = string
  },
  [types.CLEAR_QUERY_STRING] (state) {
    state.query = ''
  },
}

// actions
export const actions = {
  updateQuery ({ commit }, payload) {
    commit(types.CLEAR_QUERY_STRING)
    commit(types.QUERY_STRING, payload)
  },
}

// getters
export const getters = {
  searchQuery: state => state.query
}
