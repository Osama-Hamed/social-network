export default class Errors {
    constructor() {
        this.container = {};
    }

    has(field) {
        return this.container.hasOwnProperty(field);
    }

    any() {
        return Object.keys(this.container).length > 0;
    }

    get(field) {
        if (this.container[field]) return this.container[field][0];
    }

    record(errors) {
        this.container = errors;
    }

    clear(field) {
        if (field) {
            delete this.container[field];

            return;
        }

        this.container = {};
    }
}
