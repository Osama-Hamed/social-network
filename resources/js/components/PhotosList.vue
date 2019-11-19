<template>
	<div class="col-lg-9 offset-lg-1">
		<div class="row">
			<div class="col-lg-4 big-gallery" v-for="encodedImage in encodedImages">
				<img :src="encodedImage" class="img-fluid img-thumbnail">
			</div>
		</div>

		<p class="font-weight-bold text-center" v-if="encodedImages.length == 0">
            There is no photos to show.
    	</p>
	</div>
</template>

<script>
	export default {
		props: ['encodedImages']
	}
</script>