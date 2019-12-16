<template>
	<span class="mr-4">
        <img :src="active ? '/images/heart-solid.png' : '/images/heart.png'" class="post-action" @click="toggle">
        <small>{{ count }}</small>
    </span>
</template>

<script>
	import api from '../shared/api';

	export default {
		props: ['favoritable', 'favoritableType'],
		data() {
			return {
				count: this.favoritable.favorites_count,
				active: this.favoritable.isFavorited
			}
		},

		methods: {
			toggle() {
				if (this.active) {
					axios[api.deleteFavorite.method](api.deleteFavorite.url(this.favoritableType, this.favoritable.id))
			            .then(response => {
			            	this.active = false;
							this.count--;
			            })
			            .catch(error => {});

					return;
				}
				
				axios[api.storeFavorite.method](api.storeFavorite.url(this.favoritableType, this.favoritable.id))
					.then(response => {
			            this.active = true;
						this.count++;
		            })
		            .catch(error => {});
			},
		}
	}
</script>