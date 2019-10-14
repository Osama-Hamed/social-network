import './bootstrap';
import SocialNav from './components/SocialNav.vue';
import router from './shared/router';
import Event from './shared/event';

new Vue({
    el: '#app',

    components: {
        SocialNav,
    },

    data: {
        authUser: null,
        signedIn: false
    },

    methods: {
        assignAuthData(user) {
            this.authUser = user;
            this.signedIn = true;
        },

        resetAuthData() {
            this.authUser = null;
            this.signedIn = false;
        },
    },

    created() {
        Event.listen('authenticated', user => this.assignAuthData(user));
        Event.listen('unauthenticated', () => this.resetAuthData());
    },

    router
});
