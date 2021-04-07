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
    url: 'http://localhost:80/SoyHuCe-technical-test/public/api',
}
axios.defaults.url = 'http://localhost:80/SoyHuCe-technical-test/public/api'

Vue.prototype.$axios= axios.create(axiosConfig)
