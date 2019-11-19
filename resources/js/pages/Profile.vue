<template>
	<div class="row">
		<div class="col-lg-9 offset-lg-1">
			<div class="card px-4 pt-4 mb-4">
				<div class="media">
					<img src="/images/avatar.png" class="mr-3 big-profile-image">

					<div class="media-body">
						<h3 class="mt-3 font-weight-bold">{{ profileUser.username }}</h3>

			            <!--  -->
		            	<div v-if="editingBio">
		            		<p class="small text-danger mb-0" v-if="form.errors.has('bio')">{{form.errors.get('bio') }}</p>
							<social-textarea
				                v-model="form.bio"
				                ref="socialTextarea"
				                :placeholder="'Add a short bio...'"
				                :initialRowsCount="1"
				                :hasBorder="true"
				                @keydown.native.enter.exact.prevent="updateBio"></social-textarea>
				            <small>
				            	Press enter to post. 
				            	<a href="#" @click.prevent="editingBio = false">cancel</a>
				            </small>
				            <small class="float-right">{{ 101 - form.bio.length }}</small>
		            	</div>
			            <!--  -->

			            <!--  -->
			            <div v-if="canBeUpdated && !profileUser.bio && !editingBio">
			            	<a href="#" @click.prevent="editingBio = true">Add bio</a>
			            </div>

			            <div v-if="canBeUpdated && profileUser.bio && !editingBio" class="d-flex flex-wrap align-items-center">
			            	<img src="/images/information.png">
			            	<p class="mb-0 mr-2 ml-2">Bio  <b>{{ profileUser.bio }}</b></p>
							<img src="/images/edit.png" class="post-action" @click="editingBio = true">
			            </div>

			            <div v-if="!canBeUpdated && profileUser.bio" class="d-flex flex-wrap align-items-center">
			            	<img src="/images/information.png">
			            	<p class="mb-0 mr-2 ml-2">Bio <b>{{ profileUser.bio }}</b></p>
			            </div>
			            <!--  -->

			            <div class="d-flex flex-wrap align-items-center">
				            <img src="/images/location.png">
				            <p class="mb-0 ml-2">
				            	From
				            	<b>{{ profileUser.city + ', ' + profileUser.country }}.</b>
				        	</p>
			            </div>

			            <div class="d-flex flex-wrap align-items-center">
							<img src="/images/calendar.png" class="">
							<p class="mb-0 ml-2">
								Member since <b>{{ profileUser.created_at | membership }}</b>.
							</p>
						</div>

						<div class="d-flex flex-wrap align-items-center">
				            <img src="/images/cake.png">
				            <p class="mb-0 ml-2">
				            	Birthday
				            	<b>{{ profileUser.birthday | birthday }}.</b>
				        	</p>
			            </div>

						<div class="d-flex mt-3">
							<small class="mr-3 font-weight-bold">{{ postsCount }} {{ 'post' | pluralize(postsCount) }}</small>
							<small class="mr-3 font-weight-bold">{{ favoritesCount }} {{ 'favorite' | pluralize(favoritesCount) }}</small>
							<small class="mr-3 font-weight-bold">{{ commentsCount }} {{ 'comment' | pluralize(commentsCount) }}</small>
							<small class="font-weight-bold">20 friends</small>
						</div>

						<ul class="nav nav-tabs nav-fill font-weight-bold mt-2 border-bottom-0" v-if="isReady">
							<li class="nav-item">
								<router-link 
									class="nav-link" 
									active-class="active"
									:to="{name: 'timeline', params: {username: profileUser.username}}">Timeline</router-link>
							</li>
							<li class="nav-item">
								<router-link 
									class="nav-link" 
									active-class="active"
									:to="{name: 'friends', params: {username: profileUser.username}}">Friends</router-link>
							</li>
							<li class="nav-item">
								<router-link 
									class="nav-link" 
									active-class="active"
									:to="{name: 'photos', params: {username: profileUser.username}}">Photos</router-link>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<router-view v-bind="properties" v-if="isReady"></router-view>
	</div>
</template>

<script>
	import api from '../shared/api';
	import Collection from '../mixins/Collection';
	import moment from 'moment';
	import SocialTextarea from '../components/SocialTextarea.vue';
	import Form from '../shared/form';

	export default {
		components: {SocialTextarea},

		mixins: [Collection],

		data() {
			return {
				profileUser: '',
				postsCount: 0,
				favoritesCount: 0,
				commentsCount: 0,
				friendsCount: 0,
				editingBio: false,
				form: new Form({bio: ''}),
				isReady: false
			}
		},

		created() {
			this.fetch();
		},

		methods: {
			async fetch() {
				try {
					const response = await axios[api.profile.show.method](api.profile.show.url(this.$route.params.username));
					this.profileUser = response.data.profileUser;
					this.items = response.data.profilePosts;
					this.postsCount = response.data.profilePosts.length;
					this.items.forEach(item => this.commentsCount += item.comments_count);
					this.items.forEach(item => this.favoritesCount += item.favorites_count);
					this.form.bio = response.data.profileUser.bio ? response.data.profileUser.bio : '';
					this.isReady = true;
				} catch (error) {}
			},

			async updateBio() {
                try {
                    const response = await this.form[api.profile.update.method](api.profile.update.url(this.profileUser.username));
                    this.profileUser.bio = response.data.bio ? response.data.bio : '';
                    this.form.bio = response.data.bio ? response.data.bio : '';
                    this.editingBio = false;
                } catch (error) {}
            }
		},

		computed: {
			canBeUpdated() {
				return window.authUser.id === this.profileUser.id;
			},

			encodedImages() {
        		let encodedImages = [];
            	this.items.forEach(item => {
			 		item.encodedImages.forEach((encodedImage) => encodedImages.push(encodedImage.encoded));
			 	});

		 		return encodedImages;
            },

			properties() {
				if (this.$route.name === 'timeline' || this.$route.name === 'profile') {
					return {
						posts: this.items,
					 	encodedImages: this.encodedImages.slice(0, 9),
					 	profileUserId: this.profileUser.id
					};
				}

				if (this.$route.name === 'photos') {
				 	return {encodedImages: this.encodedImages};
				}				
			}
		},

		filters: {
            membership(value) {
                return moment(value).format('MMMM, YYYY');
            },

            birthday(value) {
                return moment(value).format('LL');
            },

            pluralize(value, amount) {
            	return (amount > 1 || amount == 0) ? `${value}s` : value;
            }
        }
	}
</script>