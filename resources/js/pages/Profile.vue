<template>
	<div class="row">
		<div class="col-lg-9 offset-lg-1" v-if="isReady">
			<div class="card px-4 pt-4 mb-4">
				<div class="media">
					<div class="d-flex flex-column">
						<img :src="owner.profile.avatarPath" class="mr-3 big-profile-image">

						<label for="profile-image-input" class="btn mb-0 mt-3 action py-1" v-if="canBeUpdated">
	                        <img src="/images/upload.png" width="20" height="20" class="mr-1">
	                        <small class="font-weight-bold">Change Picture</small>
	                    </label>
	                    <input id="profile-image-input" type="file" @change="onAvatarChange($event)" v-if="canBeUpdated">
					</div>

					<div class="media-body ml-4">
						<div class="d-flex flex-wrap align-items-center">
							<h4 class="mt-3 font-weight-bold">{{ owner.username }}</h4>

		                    <friendship :data="friendship" :profile-user="owner.username" v-if="isReady && canBeFriend"></friendship>
						</div>

			            <!--  -->
		            	<div v-if="editingBio">
		            		<p class="small text-danger mb-0" v-if="bioForm.errors.has('bio')">{{bioForm.errors.get('bio') }}</p>
							<social-textarea
				                v-model="bioForm.bio"
				                ref="socialTextarea"
				                :placeholder="'Add a short bio...'"
				                :initialRowsCount="1"
				                :hasBorder="true"
				                @keydown.native.enter.exact.prevent="updateBio"></social-textarea>
				            <small>
				            	Press enter to post. 
				            	<a href="#" @click.prevent="editingBio = false">cancel</a>
				            </small>
				            <small class="float-right">{{ 101 - bioForm.bio.length }}</small>
		            	</div>
			            <!--  -->

			            <!--  -->
			            <div v-if="canBeUpdated && !owner.profile.bio && !editingBio">
			            	<a href="#" @click.prevent="editingBio = true" class="font-weight-bold">Add bio</a>
			            </div>

			            <div v-if="canBeUpdated && owner.profile.bio && !editingBio" class="d-flex flex-wrap align-items-center">
			            	<img src="/images/information.png">
			            	<p class="mb-0 mr-2 ml-2">Bio {{ owner.profile.bio }}</p>
							<img src="/images/edit.png" class="post-action" @click="editingBio = true">
			            </div>

			            <div v-if="!canBeUpdated && owner.profile.bio" class="d-flex flex-wrap align-items-center">
			            	<img src="/images/information.png">
			            	<p class="mb-0 mr-2 ml-2">Bio {{ owner.profile.bio }}</p>
			            </div>
			            <!--  -->

			            <div class="d-flex flex-wrap align-items-center">
				            <img src="/images/location.png">
				            <p class="mb-0 ml-2">
				            	From
				            	{{ owner.profile.city + ', ' + owner.profile.country }}.
				        	</p>
			            </div>

			            <div class="d-flex flex-wrap align-items-center">
							<img src="/images/calendar.png" class="">
							<p class="mb-0 ml-2">
								Member since {{ owner.profile.created_at | date('MMMM, YYYY') }}.
							</p>
						</div>

						<div class="d-flex flex-wrap align-items-center">
				            <img src="/images/cake.png">
				            <p class="mb-0 ml-2">
				            	Birthday
				            	{{ owner.profile.birthday | date('LL') }}.
				        	</p>
			            </div>

						<div class="d-flex mt-3">
							<small class="mr-3 ">{{ postsCount }} {{ 'post' | pluralize(postsCount) }}</small>
							<small class="mr-3 ">{{ favoritesCount }} {{ 'favorite' | pluralize(favoritesCount) }}</small>
							<small class="mr-3 ">{{ commentsCount }} {{ 'comment' | pluralize(commentsCount) }}</small>
							<small class="">{{ friendsCount }} {{ 'friend' | pluralize(friendsCount) }}</small>
						</div>

						<ul class="nav nav-tabs nav-fill font-weight-bold mt-2 border-bottom-0" v-if="isReady">
							<li class="nav-item">
								<router-link 
									class="nav-link" 
									active-class="active"
									:to="{name: 'timeline', params: {username: owner.username}}">Timeline</router-link>
							</li>
							<li class="nav-item">
								<router-link 
									class="nav-link" 
									active-class="active"
									:to="{name: 'friends', params: {username: owner.username}}">Friends</router-link>
							</li>
							<li class="nav-item">
								<router-link 
									class="nav-link" 
									active-class="active"
									:to="{name: 'photos', params: {username: owner.username}}">Photos</router-link>
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
	import SocialTextarea from '../components/SocialTextarea.vue';
	import Form from '../shared/form';
	import Friendship from '../components/Friendship.vue';
	import router from '../shared/router';

	export default {
		components: {SocialTextarea, Friendship},

		mixins: [Collection],

		data() {
			return {
				owner: null,
				postsCount: 0,
				favoritesCount: 0,
				commentsCount: 0,
				friendsCount: 0,
				editingBio: false,
				bioForm: new Form({bio: ''}),
				avatarForm: new Form({avatar: ''}),
				friendship: null,
				friends: null,
				isReady: false
			}
		},

		created() {
			this.fetch();
		},

		methods: {
			async fetch() {
				try {
					const response = await axios[api.getProfile.method](api.getProfile.url(this.$route.params.username));
					this.owner = response.data.owner;
					this.items = response.data.posts;
					this.postsCount = response.data.posts.length;
					this.items.forEach(item => this.commentsCount += item.comments_count);
					this.items.forEach(item => this.favoritesCount += item.favorites_count);
					this.bioForm.bio = response.data.owner.profile.bio ? response.data.owner.profile.bio : '';
					this.friends = response.data.friends;
					this.friendsCount = response.data.friends.length;
					this.friendship = response.data.friendship;
					this.isReady = true;
				} catch (error) {
					router.push({name: 'notFound'});
				}
			},

			async updateBio() {
                try {
                    const response = await this.bioForm[api.updateProfile.method](api.updateProfile.url(this.owner.username));
                    this.owner.profile.bio = response.data.bio ? response.data.bio : '';
                    this.bioForm.bio = response.data.bio ? response.data.bio : '';
                    this.editingBio = false;
                } catch (error) {}
            },

            onAvatarChange(e) {
        		let files = e.target.files;
	            if (!files.length) return;
                let reader = new FileReader();
                reader.onload = e => {
                	this.avatarForm.avatar = e.target.result;
                	this.updateAvatar();
                }
                reader.readAsDataURL(files[0]);
            },

            async updateAvatar() {
            	try {
            		const response = await this.avatarForm[api.updateProfile.method](api.updateProfile.url(this.owner.username));
            		this.owner.profile.avatar = response.data.avatar;
            		this.owner.profile.avatarPath = response.data.avatarPath;
            		window.authUser.profile.avatarPath = response.data.avatarPath;

            		this.$nextTick(() => {
            			this.isReady = false;
            			this.commentsCount = 0;
            			this.favoritesCount = 0;
            			this.fetch();
            		});
            	} catch (error) {console.log(error);
				}
            }
		},

		computed: {
			canBeUpdated() {
				return window.authUser.id === this.owner.id;
			},

			canBeFriend() {
				return window.authUser.id !== this.owner.id;
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
					 	friends: this.friends.slice(0, 9),
					 	profileUserId: this.owner.id
					};
				}

				if (this.$route.name === 'photos') {
				 	return {encodedImages: this.encodedImages};
				}

				if (this.$route.name === 'friends') {
					return {users: this.friends}
				}
			}
		},

		filters: {
            pluralize(value, amount) {
            	return (amount > 1 || amount == 0) ? `${value}s` : value;
            }
        }
	}
</script>