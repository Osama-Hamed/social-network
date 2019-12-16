<template>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card px-3 mt-2">
                <div class="card-body">
                    <h5 class="text-center font-weight-bold">Login to your account</h5>
                    <form @submit.prevent="login">
                        <div class="form-row">
                            <div class="form-group col-lg-6 mb-0">
                                <label for="email" class="col-form-label col-form-label-sm label">E-mail Address</label>
                                <input type="text"
                                        id="email"
                                        class="form-control form-control-sm"
                                        :class="{'border-danger': form.errors.has('email') || form.errors.has('loginError')}"
                                        v-model="form.email"
                                        @keydown="form.errors.clear('email'); form.errors.clear('loginError');">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('email')">{{form.errors.get('email')}}</p>
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('loginError')">{{form.errors.get('loginError')}}</p>
                            </div>

                            <div class="form-group col-lg-6 mb-0">
                                <label for="password" class="col-form-label col-form-label-sm label">Password</label>
                                <input type="password"
                                        id="password"
                                        class="form-control form-control-sm"
                                        :class="{'border-danger': form.errors.has('password')}"
                                        v-model="form.password"
                                        @keydown="form.errors.clear('password')">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('password')">{{form.errors.get('password')}}</p>
                            </div>
                        </div>

                        <button class="btn btn-sm btn-block submit-button mt-4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../shared/api';
    import router from '../shared/router';
    import Form from "../shared/form";
    import Event from '../shared/event';
    import { setAccess, updateAuthorizationHeader } from '../shared/helpers';

    export default {
        data() {
            return {
                form: new Form({
                    email: '',
                    password: ''
                })
            }
        },

        methods: {
            async login() {
                try {
                    const response = await this.form[api.login.method](api.login.url());
                    setAccess(response.data.access_token);
                    updateAuthorizationHeader();
                    router.push({name: 'home'});
                } catch (error) {}
            }
        }
    }
</script>
