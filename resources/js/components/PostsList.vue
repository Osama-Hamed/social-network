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

            Event.listen('post-created', post => this.add(post));
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