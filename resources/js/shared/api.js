export default {
    auth: {
        register: {
            method: 'post',
            url() {
                return '/api/auth/register';
            }
        },
        login: {
            method: 'post',
            url() {
                return '/api/auth/login';
            }
        },
        logout: {
            method: 'post',
            url() {
                return '/api/auth/logout';
            }
        },
        user: {
            method: 'get',
            url() {
                return '/api/auth/user';
            }
        }
    },
}
