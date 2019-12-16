<template>
    <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <router-link :to="{name: 'home'}" class="navbar-brand">
                <img src="/images/logo.png" width="30" height="30">
                Social<b>Network</b>
            </router-link>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto" v-if="signedIn">
                    <li class="nav-item active mr-2">
                        <router-link :to="{name: 'home'}" class="bold-link nav-link">Home</router-link>
                    </li>
                    <li class="nav-item mr-2">
                        <router-link :to="{name: 'profile', params: {username: authUser.username}}" 
                            class="bold-link nav-link">
                            <img :src="authUser.profile.avatarPath" class="small-profile-image">
                            {{ authUser.first_name }}
                        </router-link>
                    </li>
                    <li class="nav-item active mr-2">
                        <router-link :to="{name: 'search'}" class="bold-link nav-link">Search</router-link>
                    </li>
                    <li class="nav-item mr-1" data-toggle="tooltip" data-placement="bottom" title="Messages">
                        <a href="#" class="nav-link">
                            <img src="/images/messenger.png" width="22" height="22">
                        </a>
                    </li>
                    <li class="nav-item mr-1" data-toggle="tooltip" data-placement="bottom" title="Notifications">
                        <a href="#" class="nav-link">
                            <img src="/images/notification.png" width="22" height="22">
                        </a>
                    </li>
                    <logout></logout>
                </ul>
                <ul class="navbar-nav ml-auto" v-else>
                    <li class="nav-item">
                        <router-link :to="{name: 'register'}" class="bold-link nav-link mr-2">Register</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'login'}" class="bold-link nav-link">Login</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import Logout from './Logout.vue';

    export default {
        props: ['signedIn', 'authUser'],

        components: { Logout },

        mounted() {
            setTimeout(() => $('[data-toggle="tooltip"]').tooltip(), 1000);
        }
    }
</script>
