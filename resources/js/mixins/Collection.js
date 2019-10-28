export default {
	data() {
		return {
			items: []
		}
	},

	methods: {
		add(item) {
			this.items.unshift(item);
		}
	}
}
