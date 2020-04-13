import Vue from 'vue'
import App from './App.vue'
import router from './router/router'
import store from './vuex/store';

import axios from 'axios';
const token = localStorage.getItem('user-token')
if (token) {
    axios.defaults.headers.common['Authorization'] = token
}

Vue.config.devtools = true;
Vue.config.productionTip = false;

new Vue({
    render: h => h(App),
    store,
    router,
}).$mount('#app')