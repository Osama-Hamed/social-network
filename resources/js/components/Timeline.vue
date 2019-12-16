<template>
	<div class="col-lg-9 offset-lg-1">
		<div class="row">
			<div class="col-lg-4">
				<div class="card mb-4">
					<router-link 
						class="p-3 mb-0 font-weight-bold" 
						:to="photosLink">Photos</router-link>
					<div class="card-body p-0">
						<div class="row p-0 m-0">
							<div class="col-lg-4 pl-1 pr-1 mb-1 small-gallery" v-for="encodedImage in encodedImages">
								<img :src="encodedImage" class="img-fluid gallery-photo">
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-4">
					<router-link 
						class="p-3 mb-0 font-weight-bold" 
						:to="friendsLink">Friends</router-link>
					<div class="card-body p-0">
						<div class="row p-0 m-0">
							<div class="col-lg-4 pl-1 pr-1 mb-1 small-gallery" v-for="friend in friends">
								<img :src="friend.profile.avatarPath" class="img-fluid gallery-photo img-thumbnail" :title="friend.username">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-8">
				<new-post v-if="canCreatePost"></new-post>

				<posts-list :posts="posts"></posts-list>
				<p class="font-weight-bold text-center" v-if="posts.length == 0">
	                This user has no posts.
            	</p>
			</div>
		</div>
	</div>
</template>

<script>
	import PostsList from '../components/PostsList.vue';
	import NewPost from '../components/NewPost.vue';
	import router from '../shared/router';

	export default {
		components: {PostsList, NewPost},

		props: ['posts', 'encodedImages', 'friends', 'profileUserId'],

		computed: {
			photosLink() {
				return router.resolve({name: 'photos'}).href;
			},

			friendsLink() {
				return router.resolve({name: 'friends'}).href;
			},

			canCreatePost() {
				return window.authUser.id === this.profileUserId;
			}
		}
	}
</script>