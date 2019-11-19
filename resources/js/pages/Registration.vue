<template>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card px-3 pt-4 pb-2 mt-2 border-0">
                <h4 class="text-center font-weight-bold">Get your free account</h4>

                <div class="card-body">
                    <form @submit.prevent="register">
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="first_name" class="col-form-label col-form-label-sm label">First
                                    Name</label>
                                <input type="text"
                                       id="first_name"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.first_name"
                                       @keydown="form.errors.clear('first_name')"
                                       :style="form.errors.has('first_name') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                <p class="small text-danger mt-1" v-if="form.errors.has('first_name')">
                                    {{form.errors.get('first_name') }}</p>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="last_name" class="col-form-label col-form-label-sm label">Last Name</label>
                                <input type="text"
                                       id="last_name"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.last_name"
                                       @keydown="form.errors.clear('last_name')"
                                       :style="form.errors.has('last_name') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                <p class="small text-danger mt-1" v-if="form.errors.has('last_name')">{{
                                    form.errors.get('last_name')}}</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label for="username" class="col-form-label col-form-label-sm label">Username</label>
                                <input type="text"
                                       id="username"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.username"
                                       @keydown="form.errors.clear('username')"
                                       :style="form.errors.has('username') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                <p class="small text-danger mt-1" v-if="form.errors.has('username')">
                                    {{form.errors.get('username') }}</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="email" class="col-form-label col-form-label-sm label">E-mail Address</label>
                                <input type="text"
                                       id="email"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.email"
                                       @keydown="form.errors.clear('email')"
                                       :style="form.errors.has('email') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                <p class="small text-danger mt-1" v-if="form.errors.has('email')">{{
                                    form.errors.get('email') }}</p>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="email_confirmation" class="col-form-label col-form-label-sm label">Confirm
                                    E-mail</label>
                                <input type="text"
                                       id="email_confirmation"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.email_confirmation">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="password" class="col-form-label col-form-label-sm label">Password</label>
                                <input type="password"
                                       id="password"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.password"
                                       @keydown="form.errors.clear('password')"
                                       :style="form.errors.has('password') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                <p class="small text-danger mt-1" v-if="form.errors.has('password')">{{
                                    form.errors.get('password')}}</p>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="password_confirmation" class="col-form-label col-form-label-sm label">Confirm
                                    Password</label>
                                <input type="password"
                                       id="password_confirmation"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       v-model="form.password_confirmation">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="birthday" class="col-form-label col-form-label-sm label">Birthday</label>
                                <input type="text"
                                       id="birthday"
                                       class="form-control form-control-sm border-bottom-only p-0"
                                       placeholder="dd/mm/yyyy"
                                       v-model="form.birthday"
                                       @keydown="form.errors.clear('birthday')"
                                       :style="form.errors.has('birthday') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                <p class="small text-danger mt-1" v-if="form.errors.has('birthday')">{{
                                    form.errors.get('birthday')}}</p>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="gender" class="col-form-label col-form-label-sm label">Gender</label>
                                <select id="gender"
                                        class="form-control form-control-sm border-bottom-only p-0"
                                        v-model="form.gender"
                                        @keydown="form.errors.clear('gender')"
                                        :style="form.errors.has('gender') ? 'border-color: #e3342f' : 'border-color: #8D8C8A'">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p class="small text-danger mt-1" v-if="form.errors.has('gender')">{{
                                    form.errors.get('gender') }}</p>
                            </div>
                        </div>

                        <button class="btn submit-button">Register</button>
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
    import {setAccess, updateAuthorizationHeader} from '../shared/helpers';

    export default {
        data() {
            return {
                form: new Form({
                    first_name: '',
                    last_name: '',
                    username: '',
                    email: '',
                    email_confirmation: '',
                    password: '',
                    password_confirmation: '',
                    birthday: '',
                    gender: ''
                })
            }
        },

        methods: {
            async register() {
                try {
                    const response = await this.form[api.auth.register.method](api.auth.register.url());
                    setAccess(response.data.access_token);
                    updateAuthorizationHeader();
                    Event.fire('authenticated', response.data.user);
                    router.push({name: 'home'});
                } catch (error) {
                }
            }
        }
    }
</script>
