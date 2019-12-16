<template>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card px-3 mt-2">
                <div class="card-body">
                    <h5 class="text-center font-weight-bold">Get your free account</h5>
                    
                    <form @submit.prevent="register">
                        <div class="form-row">
                            <div class="form-group col-lg-6 mb-0">
                                <label for="first_name" class="col-form-label col-form-label-sm label">First Name</label>
                                <input type="text"
                                       id="first_name"
                                       class="form-control form-control-sm"
                                       :class="{'border-danger': form.errors.has('first_name')}"
                                       v-model="form.first_name"
                                       @keydown="form.errors.clear('first_name')">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('first_name')">{{form.errors.get('first_name')}}</p>
                            </div>
                            <div class="form-group col-lg-6 mb-0">
                                <label for="last_name" class="col-form-label col-form-label-sm label">Last Name</label>
                                <input type="text"
                                       id="last_name"
                                       class="form-control form-control-sm"
                                       :class="{'border-danger': form.errors.has('last_name')}"
                                       v-model="form.last_name"
                                       @keydown="form.errors.clear('last_name')">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('last_name')">{{form.errors.get('last_name')}}</p>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6 mb-0">
                                <label for="email" class="col-form-label col-form-label-sm label">E-mail Address</label>
                                <input type="text"
                                       id="email"
                                       class="form-control form-control-sm"
                                       :class="{'border-danger': form.errors.has('email')}"
                                       v-model="form.email"
                                       @keydown="form.errors.clear('email')">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('email')">{{form.errors.get('email')}}</p>
                            </div>
                            <div class="form-group col-lg-6 mb-0">
                                <label for="username" class="col-form-label col-form-label-sm label">Username</label>
                                <input type="text"
                                       id="username"
                                       class="form-control form-control-sm"
                                       :class="{'border-danger': form.errors.has('username')}"
                                       v-model="form.username"
                                       @keydown="form.errors.clear('username')">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('username')">{{form.errors.get('username')}}</p>
                            </div>
                        </div>

                        <div class="form-row">
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
                            <div class="form-group col-lg-6 mb-0">
                                <label for="password_confirmation" class="col-form-label col-form-label-sm label">Confirm Password</label>
                                <input type="password"
                                       id="password_confirmation"
                                       class="form-control form-control-sm"
                                       v-model="form.password_confirmation">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-6 mb-0">
                                <label for="birthday" class="col-form-label col-form-label-sm label">Birthday</label>
                                <input type="text"
                                       id="birthday"
                                       class="form-control form-control-sm"
                                       :class="{'border-danger': form.errors.has('birthday')}"
                                       placeholder="dd/mm/yyyy"
                                       v-model="form.birthday"
                                       @keydown="form.errors.clear('birthday')">
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('birthday')">{{form.errors.get('birthday')}}</p>
                            </div>
                            <div class="form-group col-lg-6 mb-0">
                                <label for="gender" class="col-form-label col-form-label-sm label">Gender</label>
                                <select id="gender"
                                        class="form-control form-control-sm"
                                        :class="{'border-danger': form.errors.has('gender')}"
                                        v-model="form.gender"
                                        @keydown="form.errors.clear('gender')">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p class="small text-danger mt-1 mb-0" v-if="form.errors.has('gender')">{{form.errors.get('gender')}}</p>
                            </div>
                        </div>

                        <button class="btn btn-sm btn-block submit-button mt-4">Register</button>
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
                    const response = await this.form[api.register.method](api.register.url());
                    setAccess(response.data.access_token);
                    updateAuthorizationHeader();
                    router.push({name: 'home'});
                } catch (error) {}
            }
        }
    }
</script>
