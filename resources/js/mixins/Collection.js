export default {
	data() {
		return {
			items: []
		}
	},

	methods: {
		add(item) {
			this.items.unshift(item);
		},

		replace(index, item) {
			this.items.splice(index, 1, item);
		},

		remove(index) {
			this.items.splice(index, 1);
		}
	}
}
