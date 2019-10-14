import VueRouter from 'vue-router';
import Event from '../shared/event';
import { getUser, hasAccess, removeAccess } from './helpers';

const routes = [
    {
        path: '/register',
        name: 'register',
        component: require('../pages/Registration.vue').default,
        meta: {
            guest: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: require('../pages/Login.vue').default,
        meta: {
            guest: true
        }
    },
    {
        path: '/',
        name: 'home',
        component: require('../pages/Home.vue').default,
        meta: {
            requiresAuth: true
        }
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (hasAccess()) {
            getUser()
                .then(({data}) => {
                    Event.fire('authenticated', data);
                    next();
                })
                .catch(error => {
                    removeAccess();
                    Event.fire('unauthenticated');
                    next({name: 'login'});
                });
        } else {
            Event.fire('unauthenticated');
            next({name: 'login'});
        }

    } else if (to.matched.some(record => record.meta.guest)) {
        if (hasAccess()) {
            getUser()
                .then(({data}) => {
                    Event.fire('authenticated', data);
                    next({name: 'home'});
                })
                .catch(error => {
                    removeAccess();
                    Event.fire('unauthenticated');
                    next();
                });
        } else {
            Event.fire('unauthenticated');
            next();
        }
    }
});

export default router;