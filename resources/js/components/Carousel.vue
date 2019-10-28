<template>
    <div class="carousel pt-3">
        <img :src="'/storage/posts/' + src" v-for="src in srcs" class="w-100 h-100">
    </div>
</template>

<script>
    import Flickity from 'flickity';
    import 'flickity/dist/flickity.min.css';

    export default {
        props: ['srcs'],

        methods: {
            initialize() {
                new Flickity(this.$el, {
                    wrapAround: true,
                    pageDots: false,
                    autoPlay: false,
                });
            }
        },

        mounted() {
            this.initialize();
        }
    }
</script>
