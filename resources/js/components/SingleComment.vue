<template>
	<div class="comment mx-4 mt-2 px-3">
		<div class="media py-2">
			<img :src="'images/' + data.owner.avatar" class="mr-3 small-profile-image">
			<div class="media-body my-auto">
				<p class="mb-0 ">
					<a href="#" class="font-weight-bold username small">{{ data.owner.first_name + ' ' + data.owner.last_name }}</a>
					<a href="#" class="small date">{{ data.created_at | date }}</a>
				</p>
				<p class="mb-0 comment-content" v-if="! editing">{{ data.body }}</p>
				<edit-comment :data="data" @cancel="editing = false" v-else></edit-comment>
			</div>

			<div class="dropdown float-right" v-if="canBeUpdated">
                <img src="/images/menu.png" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right py-1" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item px-3 py-0 small" href="#" @click.prevent="editing = true">Edit</a>
                    <a class="dropdown-item px-3 py-0 small" href="#">Delete</a>
                </div>
            </div>
		</div>
	</div>
</template>

<script>
	import moment from 'moment';
	import EditComment from './EditComment.vue';
	
	export default {
		props: ['data', 'postOwnerId'],

		components: {EditComment},

		data() {
			return {
				editing: false
			}
		},

		computed: {
			canBeUpdated() {
				return window.authUser.id === this.data.user_id;
			}
		},

		filters: {
            date(value) {
                return moment(value).fromNow();
            }
        }
	}
</script>