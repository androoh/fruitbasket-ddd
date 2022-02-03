/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// start the Stimulus application
import './bootstrap';

import Home from './components/Home';
import App from './components/App';
import Edit from './components/Edit';
import Create from './components/Create';
import BasketItems from './components/BasketItems';
import './styles/app.css';

import Vue from 'vue'
import VueRouter from 'vue-router'


const routes = [
    { path: '/', component: Home, name: 'home' },
    { path: '/edit/:id', component: Edit, name: 'edit' },
    { path: '/edit/:id/items', component: BasketItems, name: 'basket_items' },
    { path: '/create', component: Create, name: 'basket_create' }
]

const router = new VueRouter({
    base: '/',
    routes
})

Vue.use(VueRouter)

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')