<template>
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="form-group">
				<input 
					type="text" 
					class="form-control form-control-lg p-4" 
					placeholder="Search..."
					v-model="query">
			</div>

			<div class="form-group mt-3 d-flex flex-wrap align-items-center">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="posts" value="posts" v-model="resource">
					<label class="form-check-label text-secondary font-weight-bold" for="posts">posts</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" id="users" value="users" v-model="resource">
					<label class="form-check-label text-secondary font-weight-bold" for="users">users</label>
				</div>

				<button class="btn px-3 py-1 ml-auto action" @click.prevent="search">
					<small class="font-weight-bold">Search</small>
				</button>
			</div>
		</div>

		<div class="col-lg-6 offset-lg-3" v-if="hasResult">
			<posts-list v-if="resultType == 'posts'" :posts="results"></posts-list>

			<div class="row" v-if="resultType == 'users'">
				<div class="col-lg-6" v-for="result in results">
					<div class="card mb-2">
						<div class="card-body py-2">
							<div class="media d-flex flex-wrap align-items-center">
								<img :src="result.profile.avatarPath" class="mr-3 small-profile-image">
								<div class="media-body mt-2">
									<p class="mb-0">
					                    <router-link :to="{name: 'profile', params: {username: result.username}}" class="font-weight-bold username">
					                        {{ result.first_name + ' ' + result.last_name }}
					                    </router-link>
					                </p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 offset-lg-3" v-if="results.length == 0">
			<p class="font-weight-bold text-center">
	        	There is no results to show.
			</p>
		</div>
	</div>
</template>

<script>
	import api from '../shared/api';
	import PostsList from '../components/PostsList.vue';

	export default {
		components: {PostsList},

		data() {
			return {
				query: '',
				resource: 'posts',
				resultType: '',
				hasResult: false,
				results: []
			}
		},

		methods: {
			async search() {
				try {
					this.hasResult = false;
					const response = await axios[api.search.method](api.search.url(this.resource), {
						params: {q: this.query, r: this.resource}
					});

					this.results = response.data;
					this.resultType = this.resource == 'posts' ? 'posts' : 'users';
					this.hasResult = true;
				} catch (error) {}
			}
		}
	}
</script>