<template>
    <div class="media mx-4 mt-3">
        <img src="images/avatar.png" class="mr-3 small-profile-image">

        <div class="media-body my-auto">
            <social-textarea
                v-model="form.body"
                ref="socialTextarea"
                :initialRowsCount="1"
                :hasBorder="true"
                @keydown.native.enter.exact.prevent="add"></social-textarea>

            <span class="small">Click enter to post.</span>
        </div>
    </div>
</template>

<script>
    import SocialTextarea from './SocialTextarea.vue';
    import api from '../shared/api';
    import Form from '../shared/form';
    import Event from '../shared/event';

    export default {
        props: ['postId'],

        components: {SocialTextarea},

        data() {
            return {
                form: new Form({ body: '' })
            }
        },

        methods: {
            async add() {
                try {
                    const response = await this.form[api.comment.create.method](api.comment.create.url(this.postId));
                    Event.fire('comment-created', response.data);
                } catch (error) {}
            }
        }
    }
</script>
