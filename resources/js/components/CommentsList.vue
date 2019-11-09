<template>
	<div class="comments">
		<single-comment v-for="comment in items" :key="comment.id" :data="comment"></single-comment>
	</div>
</template>

<script>
	import SingleComment from './SingleComment.vue';
	import collection from '../mixins/Collection';
	import Event from '../shared/event';

	export default {
		props: ['post'],

		mixins: [collection],
		
		components: {SingleComment},

		created() {
			this.assignComments();

			Event.listen('comment-created', comment => {
				if (this.post.id === comment.post_id) this.add(comment);
			});
		},

		methods: {
			assignComments() {
				this.items = this.post.comments;
			}
		}
	}
</script>