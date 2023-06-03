import { createStore } from 'vuex'
const axios = require("axios").default;

export default createStore({
  state: {
    'url_base' : 'http://localhost:8000/',
    // 'url_base' : 'https://gerencia.comprasentacna.com/api/',
    sidebarVisible: true,
    sidebarUnfoldable: true,
    ip_address:'',
  },
  mutations: {
    toggleSidebar(state) {
      console.log(state)
      state.sidebarVisible = !state.sidebarVisible
    },
    toggleUnfoldable(state) {
      state.sidebarUnfoldable = !state.sidebarUnfoldable
    },
    updateSidebarVisible(state, payload) {
      state.sidebarVisible = payload.value
    },
    updateIpAddress(state, ip_address) {
      state.ip_address = ip_address
    }


  },
  actions: {
    async fetchIpAddress({ commit }) {
      const data = await axios.get('https://api.ipify.org?format=json')
      commit('updateIpAddress', data.data.ip)
    }
  },
  modules: {},
})
