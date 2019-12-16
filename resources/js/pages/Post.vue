<template>
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<single-post :data="data" v-if="isReady"></single-post>

			<p class="font-weight-bold text-center mt-4" v-if="isReady && data.length == 0">This content is not available right now.</p>
		</div>
	</div>
</template>

<script>
	import SinglePost from '../components/SinglePost.vue';
	import api from '../shared/api';
	import router from '../shared/router';

	export default {
		components: {SinglePost},

		data() {
			return {
				data: [],
				isReady: false
			}
		},

		created() {
			this.fetch();
		},

		methods: {
			async fetch() {
				try {
					const response  = await axios[api.getPost.method](api.getPost.url(this.$route.params.post));
					this.data = response.data;
					this.isReady = true;
				} catch (error) {
					router.push({name: 'notFound'});
				}
			}
		}
	}
</script>