<template>
    <li class="nav-item">
        <a href="#" class="nav-link" @click.prevent="logout">
            <img src="/images/logout.png" width="22" height="22">
        </a>
    </li>
</template>

<script>
    import api from '../shared/api';
    import router from '../shared/router';
    import Event from '../shared/event';
    import { removeAccess } from '../shared/helpers';

    export default {
        methods: {
            logout() {
                axios[api.auth.logout.method](api.auth.logout.url())
                    .then(response => {
                        removeAccess();
                        Event.fire('unauthenticated');
                        router.push({name: 'login'});
                    })
                    .catch(error => {});
            }
        }
    }
</script>
