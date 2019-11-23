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

    post: {
        create: {
            method: 'post',
            url() {
                return '/api/posts';
            }
        },
        all: {
            method: 'get',
            url() {
                return '/api/posts';
            }
        },
        update: {
            method: 'patch',
            url(id) {
                return '/api/posts/' + id;
            }
        },
        delete: {
            method: 'delete', 
            url(id) {
                return '/api/posts/' + id;
            }
        }
    },

    comment: {
        create: {
            method: 'post',
            url(postId) {
                return '/api/posts/' + postId + '/comments';
            }
        },
        update: {
            method: 'patch',
            url(id) {
                return '/api/comments/' + id;
            }
        },
        delete: {
            method: 'delete',
            url(id) {
                return '/api/comments/' + id;
            }
        }
    },

    favorite: {
        create: {
            method: 'post',
            url(type, id) {
                return '/api/' + type + 's/' + id + '/favorites';
            }
        },
        delete: {
            method: 'delete',
            url(type, id) {
                return '/api/' + type + 's/' + id + '/favorites';
            }
        }
    },

    profile: {
        show: {
            method: 'get',
            url(username) {
                return '/api/profile/' + username;
            }
        },
        update: {
            method: 'patch',
            url(username) {
                return '/api/profile/' + username
            }
        }
    },

    friendship: {
        create: {
            method: 'post',
            url() {
                return '/api/friends';
            }
        },

        update: {
            method: 'patch',
            url(username) {
                return '/api/friends/' + username;
            }
        },

        delete: {
            method: 'delete',
            url(username) {
                return '/api/friends/' + username;
            }
        }
    }
}
