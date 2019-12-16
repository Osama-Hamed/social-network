<template>
	<div>
		<button class="btn ml-3 action py-0" @click.prevent="handle">
	        <small class="font-weight-bold">{{ action }}</small>
	    </button>

	    <button class="btn ml-3 action py-0" v-if="isRecieved" @click.prevent="reject">
	        <small class="font-weight-bold">Delete Request</small>
	    </button>
	</div>
</template>

<script>
	import api from '../shared/api';

	export default {
		props: ['data', 'profileUser'],

		data() {
			return {
				isEstablished: false,
				isRecieved: false,
				isSent: false
			}
		},

		created() {
			this.isEstablished = this.data.isEstablished;
			this.isRecieved = this.data.isRecieved;
			this.isSent = this.data.isSent;
		},

		computed: {
			action() {
				if (!this.isEstablished && !this.isRecieved && !this.isSent) return 'Add Friend';
				if (this.isEstablished) return 'Unfriend';
				if (this.isRecieved) return 'Confirm Request';
				if (this.isSent) return 'Cancel Request';
			}
		},

		methods: {
			handle() {
				if (this.action === 'Add Friend') this.request();
				if (this.action === 'Unfriend' || this.action === 'Cancel Request') this.reject();
				if (this.action === 'Confirm Request') this.accept();
			},

			async request() {
				try {
					const response = await axios[api.storeFriendship.method](api.storeFriendship.url(), {username: this.profileUser});
					this.isEstablished = false;
					this.isSent = true;
					this.isRecieved = false;
				} catch (error) {console.log(error)}
			},

			async reject() {
				try {
					const response = await axios[api.deleteFriendship.method](api.deleteFriendship.url(this.profileUser));
					this.isEstablished = false;
					this.isSent = false;
					this.isRecieved = false;
				} catch (error) {}
			},

			async accept() {
				try {
					const response = await axios[api.updateFriendship.method](api.updateFriendship.url(this.profileUser));
					this.isEstablished = true;
					this.isSent = false;
					this.isRecieved = false;
				} catch (error) {}
			}
		}
	}
</script>