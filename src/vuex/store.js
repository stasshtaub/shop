import Vue from 'vue'
import Vuex from 'vuex'

import userModule from './modules/user/userModule'
import catalogModule from './modules/catalog/catalogModule'

Vue.use(Vuex);
Vue.config.devtools = true;

let store = new Vuex.Store({
    modules: {
        userModule,
        catalogModule
    }
});

export default store;