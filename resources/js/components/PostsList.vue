<template>
    <div>
        <single-post v-for="post in items" :key="post.id" :data="post"></single-post>
    </div>
</template>

<script>
    import SinglePost from './SinglePost.vue';
    import Collection from '../mixins/Collection';
    import Event from '../shared/event';
    import api from '../shared/api';

    export default {
        components: {SinglePost},

        mixins: [Collection],

        created() {
            this.fetch();

            Event.listen('post-created', post => {
                post.comments = [];
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

        methods: {
            async fetch() {
                try {
                    const response = await axios[api.post.all.method](api.post.all.url());
                    this.items = response.data;
                } catch (error) {}
            }
        }
    }
</script>
