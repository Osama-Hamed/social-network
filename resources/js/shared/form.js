import Errors from './errors';

export default class Form {
    constructor(data) {
        this.originalData = data;

        Object.assign(this, data);

        this.errors = new Errors();
    }

    data() {
        let data = {};

        for (let field in this.originalData) data[field] = this[field];

        return data;
    }

    reset() {
        for (let field in this.originalData) {
            if (Array.isArray(this[field])) this[field] = [];
            else this[field] = '';
        }

        this.errors.clear();
    }

    post(url) {
        return this.submit('post', url);
    }

    put(url) {
        return this.submit('put', url);
    }

    patch(url) {
        return this.submit('patch', url);
    }

    delete(url) {
        return this.submit('delete', url);
    }

    submit(requestType, url) {
        return axios[requestType](url, this.data())
            .then(this.onSuccess.bind(this))
            .catch(this.onFail.bind(this));
    }

    onSuccess(response) {
        this.reset();

        return response;
    }

    onFail(error) {
        this.errors.record(error.response.data.errors);

        throw error;
    }
}
