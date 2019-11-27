<template>
	<div class="col-lg-9 offset-lg-1">
		<div class="row">
			<div class="col-lg-4" v-for="user in users">
				<div class="card mb-3">
					<div class="card-body py-2">
						<div class="media d-flex flex-wrap align-items-center">
							<img :src="user.avatarPath" class="mr-3 medium-profile-image">
							<div class="media-body mt-2">
								<p class="mb-0">
				                    <router-link :to="{name: 'profile', params: {username: user.username}}" class="font-weight-bold username">
				                        {{ user.first_name + ' ' + user.last_name }}
				                    </router-link>
				                </p>
				                <p class="small">since {{ user.friendship.accepted_at | date }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<p class="font-weight-bold text-center" v-if="users.length == 0">
            There is no friends to show.
    	</p>
	</div>
</template>

<script>
	import moment from 'moment';

	export default {
		props: ['users'],

		filters: {
    	 	date(value) {
                return moment(value).format('LL');
            }
        }
	}
</script>