import api from './api';

export const ACCESS_NAME = 'access_token';

export let updateAuthorizationHeader = () => window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + getAccess();

export let getAccess = () => localStorage.getItem(ACCESS_NAME);

export let setAccess = token => localStorage.setItem(ACCESS_NAME, token);

export let hasAccess = () => localStorage.getItem(ACCESS_NAME);

export let removeAccess = () => localStorage.removeItem(ACCESS_NAME);

export let getAuthUser = () => axios[api.getAuthUser.method](api.getAuthUser.url());