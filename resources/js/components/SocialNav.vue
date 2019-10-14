<template>
    <nav class="navbar navbar-expand-lg sticky-top mb-4 navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" width="30" height="30">
                <span class="font-weight-normal">Social</span><span class="font-weight-bolder">Network</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto" v-if="signedIn">
                    <li class="nav-item active mr-2">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="#">
                            <img :src="'images/' + authUser.avatar" class="small-profile-image">
                            {{ authUser.first_name }}
                        </a>
                    </li>
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link">
                            <img src="images/messenger.png" width="22" height="22">
                        </a>
                    </li>
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link">
                            <img src="images/notification.png" width="22" height="22">
                        </a>
                    </li>
                    <logout></logout>
                </ul>
                <ul class="navbar-nav ml-auto" v-else>
                    <li class="nav-item">
                        <router-link to="/register" class="nav-link mr-2">Register</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/login" class="nav-link">Login</router-link>
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

        components: { Logout }
    }
</script>
