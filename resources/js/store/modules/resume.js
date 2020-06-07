import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  data   : null,
  status : null,
  resume : null,
}

// getters
export const getters = {
  data   : state => state.data,
  status : state => state.status,
  resume : state => state.resume,
}


// mutations
export const mutations = {
  
  [types.FETCH_RESUME] (state ,{ resume }) {
    state.data = resume
  },
  [types.FETCH_RESUME_SUCCESS] (state ,{ status }) {
    state.status = status
  },
  
  [types.UPDATE_RESUME] (state, { resume }) {
    state.resume = resume
  },

  [types.FETCH_RESUME_FAILURE] (state) {
    console.log('error')
  },
}

// actions
export const actions = {
  async fetchResume ({ commit }) {
    try {
      const { data } = await axios.get('/api/resume')
      commit(types.FETCH_RESUME, { resume: data })
    } catch (e) {
      commit(types.FETCH_RESUME_FAILURE)
    }
  },
  async deleteResume ({ commit }, id) {
    try {
      const { data } = await axios.delete('/api/resume/'+id)
      commit(types.FETCH_RESUME_SUCCESS, { status: data })
    } catch (e) {
      commit(types.FETCH_RESUME_FAILURE)
    }
  },

  async editResume ({ commit }, id) {
    try {
        const { data } = await axios.get('/api/resume/'+id+'/edit')
        commit(types.UPDATE_RESUME, { resume: data })
      } catch (e) {
        commit(types.FETCH_RESUME_FAILURE)
      }
  },
}
