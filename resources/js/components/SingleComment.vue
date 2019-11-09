<template>
	<div class="comment mx-4 mt-2 px-3">
		<div class="media py-2">
			<img :src="'images/' + data.owner.avatar" class="mr-3 small-profile-image">
			<div class="media-body my-auto">
				<p class="mb-0 ">
					<a href="#" class="font-weight-bold username small">{{ data.owner.first_name + ' ' + data.owner.last_name }}</a>
					<a href="#" class="small date">{{ data.created_at | date }}</a>
				</p>
				<p class="mb-0 comment-content">{{ data.body }}</p>
			</div>
		</div>
	</div>
</template>

<script>
	import moment from 'moment';
	
	export default {
		props: ['data'],

		filters: {
            date(value) {
                return moment(value).fromNow();
            }
        }
	}
</script>