import VueRouter from 'vue-router';
import Home from './views/Home';
import Room from './views/room';
import Error from './views/Error';

import Vue from 'vue';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/room/:id',
            name: 'room',
            component: Room
        },
        {
            path: '/404',
            name: '404',
            component: Error
        },
        {
            path: '*',
            redirect: '/404'
        },
    ],
});
