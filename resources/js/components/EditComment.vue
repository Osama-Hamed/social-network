<template>
    <div>
        <social-textarea
            v-model="form.body"
            ref="socialTextarea"
            :initialRowsCount="1"
            :hasBorder="true"
            @keydown.native.enter.exact.prevent="update"></social-textarea>

        <span class="small">Click enter to post.</span>
        <a href="#" class="small" @click.prevent="$emit('cancel')">cancel</a>
    </div>
</template>

<script>
    import SocialTextarea from './SocialTextarea.vue';
    import api from '../shared/api';
    import Form from '../shared/form';
    import Event from '../shared/event';

    export default {
        props: ['data'],

        components: {SocialTextarea},

        data() {
            return {
                form: new Form({ body: '' })
            }
        },

        created() {
            this.showComment();
        },

        mounted() {
            this.$refs.socialTextarea.focus();
        },

        methods: {
            async update() {
                try {
                    const response = await this.form[api.comment.update.method](api.comment.update.url(this.data.id));
                    Event.fire('comment-updated', response.data);
                } catch (error) {}
            },

            showComment() {
                this.form.body = this.data.body;
            }
        }
    }
</script>
