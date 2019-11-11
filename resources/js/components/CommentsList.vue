<template>
	<div class="comments">
		<single-comment v-for="comment in items" :key="comment.id" :data="comment" :post-owner-id="post.owner.id"></single-comment>
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

			Event.listen('comment-updated', comment => {
				if (this.post.id === comment.post_id) this.replace(comment, this.items.findIndex((item) => item.id == comment.id));

				// let index = this.items.findIndex((item) => item.id == comment.id);

				// this.$set(this.items[index], 'body', comment.body);
			});

			Event.listen('comment-deleted', comment => {
				if (this.post.id === comment.post_id) this.remove(this.items.findIndex((item) => item.id == comment.id));
			});
		},

		methods: {
			assignComments() {
				this.items = this.post.comments;
			}
		}
	}
</script>