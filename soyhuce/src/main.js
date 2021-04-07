import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App.vue'
import './index.css'

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app')

Vue.use(VueAxios, axios)

const axiosConfig = {
    baseUrl: 'http://localhost:8000/api',
}
// axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

Vue.prototype.$axios= axios.create(axiosConfig)
