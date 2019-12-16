import './bootstrap';
import SocialNav from './components/SocialNav.vue';
import router from './shared/router';
import Event from './shared/event';
import moment from 'moment';

Vue.filter('date', (value, format) => {
    if (format === 'formNow') return moment(value).fromNow();
    return moment(value).format(format);
});

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

            window.authUser = user;
        },

        resetAuthData() {
            this.authUser = null;
            this.signedIn = false;

            window.authUser = null;
        },
    },

    created() {
        Event.listen('authenticated', user => this.assignAuthData(user));
        Event.listen('unauthenticated', () => this.resetAuthData());
    },

    router
});
