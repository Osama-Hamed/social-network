<template>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card px-3 pt-4 pb-2 mt-4 border-0">
                <h4 class="text-center font-weight-bold">Login to your account</h4>

                <div class="card-body">
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <label for="email" class="col-form-label col-form-label-sm label">E-mail Address</label>
                            <input type="text"
                                   id="email"
                                   class="form-control form-control-sm border-bottom-only p-0"
                                   v-model="form.email"
                                   @keydown="form.errors.clear('email'); form.errors.clear('loginError');"
                                   :style="form.errors.has('email') || form.errors.has('loginError') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                            <p class="small text-danger mt-1" v-if="form.errors.has('email')">{{form.errors.get('email') }}</p>
                            <p class="small text-danger mt-1" v-if="form.errors.has('loginError')">{{form.errors.get('loginError') }}</p>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label col-form-label-sm label">Password</label>
                            <input type="password"
                                   id="password"
                                   class="form-control form-control-sm border-bottom-only p-0"
                                   v-model="form.password"
                                   @keydown="form.errors.clear('password')"
                                   :style="form.errors.has('password') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                            <p class="small text-danger mt-1" v-if="form.errors.has('password')">{{form.errors.get('password') }}</p>
                        </div>

                        <button class="btn submit-button">Login</button>
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
                    const response = await this.form[api.auth.login.method](api.auth.login.url());
                    setAccess(response.data.access_token);
                    updateAuthorizationHeader();
                    Event.fire('authenticated', response.data.user);
                    router.push({name: 'home'});
                } catch (error) {}
            }
        }
    }
</script>