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

		replace(item, index) {
			this.remove(index);

			this.$nextTick(() => this.add(item));
		},

		remove(index) {
			this.items.splice(index, 1);
		}
	}
}
