<template>
    <div>
        <single-post v-for="post in items" :key="post.id" :data="post"></single-post>
    </div>
</template>

<script>
    import SinglePost from './SinglePost.vue';
    import Collection from '../mixins/Collection';
    import Event from '../shared/event';

    export default {
        components: {SinglePost},

        props: ['posts'],

        mixins: [Collection],

        created() {
            this.items = this.posts;

            Event.listen('post-created', post => {
                post.comments = [];
                post.favorites_count = 0;
                this.add(post);
            });

            Event.listen('post-updated', post => {
                let index = this.items.findIndex((item) => item.id == post.id);
                this.remove(index);
                this.$nextTick(() => this.add(post));

                window.scrollTo(0, 0);
            });

            Event.listen('post-deleted', postId => {
                let index = this.items.findIndex((item) => item.id == postId);
                this.remove(index);
            });
        },

        beforeDestroy() {
            Event.stopListening('post-created');
            Event.stopListening('post-updated');
            Event.stopListening('post-deleted');
        }
    }
</script>
