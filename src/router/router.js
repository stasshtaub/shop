import Vue from 'vue'
import Router from 'vue-router'
import mainView from '../views/main'
import loginView from '../views/login'
import signupView from '../views/signup'

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [{
        path: '/',
        name: 'main',
        component: mainView
    }, {
        path: '/login',
        name: 'login',
        component: loginView
    }, {
        path: '/signup',
        name: 'signup',
        component: signupView
    }]
});

export default router;