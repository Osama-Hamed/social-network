import VueRouter from 'vue-router';
import Event from '../shared/event';
import { getAuthUser, hasAccess, removeAccess } from './helpers';

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
    },
    {
        path: '/profile/:username',
        component: require('../pages/Profile.vue').default,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '',
                name: 'profile',
                component: require('../components/Timeline.vue').default,
            },
            {
                path: 'timeline',
                name: 'timeline',
                component: require('../components/Timeline.vue').default,
            },
            {
                path: 'friends',
                name: 'friends',
                component: require('../components/FriendsList.vue').default,
            },{
                path: 'photos',
                name: 'photos',
                component: require('../components/PhotosList.vue').default,
            }
        ]
    },
    {
        path: '/search',
        name: 'search',
        component: require('../pages/Search.vue').default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/posts/:post',
        name: 'post',
        component: require('../pages/Post.vue').default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/404',
        name: 'notFound',
        component: require('../pages/NotFound.vue').default,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '*',
        component: require('../pages/NotFound.vue').default,
        meta: {
            requiresAuth: true
        }
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (hasAccess()) {
            getAuthUser()
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
            getAuthUser()
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