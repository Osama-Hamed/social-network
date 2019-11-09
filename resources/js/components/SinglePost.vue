<template>
    <div class="card border-0 mb-4 pb-4">
        <div class="media mx-4 mt-3">
            <img :src="'images/' + data.owner.avatar" class="mr-3 medium-profile-image">
            <div class="media-body my-auto">
                <p class="mb-0 ">
                    <a href="#" class="font-weight-bold username">{{ data.owner.first_name + ' ' + data.owner.last_name
                        }}</a>
                </p>
                <p class="mb-0">
                    <a href="#" class="small date">{{ data.created_at | date }}</a>
                </p>
            </div>
            <div class="dropdown float-right" v-if="canBeManaged">
                <img src="/images/menu.png" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <div class="dropdown-menu dropdown-menu-right py-1" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item px-3 py-0 small" href="#" @click.prevent="editing = true">Edit</a>
                    <a class="dropdown-item px-3 py-0 small" href="#" @click.prevent="deleting = true">Delete</a>
                </div>
            </div>
        </div>

        <div class="card-body pt-3 pb-0">
            <p class="card-text post-content">{{ data.body }}</p>
        </div>

        <carousel v-if="data.images.length" :srcs="data.images"></carousel>

        <div class="d-flex mx-auto mt-3">
            <span class="mr-4">
                <img src="/images/heart.png" class="post-action">
                <small>5</small>
            </span>
            <span class="mr-4">
                <img src="/images/comment.png" class="post-action" @click="focusOnCommentsInput">
                <small>{{ commentsCount }}</small>
            </span>
            <span>
                <img src="/images/share.png" class="post-action">
                <small>14</small>
            </span>
        </div>

        <new-comment :post-id="data.id" ref="newComment"></new-comment>
        <comments-list :post="data"></comments-list>

        <edit-post v-if="editing" :data="data" @cancel="editing = false"></edit-post>
        <delete-post v-if="deleting" :id="data.id" @cancel="deleting = false"></delete-post>
    </div>
</template>

<script>
    import Carousel from './Carousel.vue';
    import moment from 'moment';
    import EditPost from './EditPost.vue';
    import DeletePost from './DeletePost.vue';
    import NewComment from './NewComment.vue';
    import CommentsList from './CommentsList.vue';

    export default {
        props: ['data'],

        components: {Carousel, EditPost, DeletePost, NewComment, CommentsList},

        data() {
            return {
                editing: false,
                deleting: false
            }
        },

        methods: {
            focusOnCommentsInput() {
                this.$refs.newComment.$refs.socialTextarea.focus();
            }
        },

        computed: {
            canBeManaged() {
                return window.authUser.id === this.data.user_id;
            },

            commentsCount() {
                return this.data.comments.length;
            }
        },

        filters: {
            date(value) {
                return moment(value).format('LLL');
            }
        }
    }
</script>
