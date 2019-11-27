<template>
    <div class="card mb-4 pb-4">
        <div class="media mx-4 mt-3">
            <img :src="data.owner.avatarPath" class="mr-3 medium-profile-image">
            <div class="media-body my-auto">
                <p class="mb-0 ">
                    <router-link :to="{name: 'profile', params: {username: data.owner.username}}" class="font-weight-bold username">
                        {{ data.owner.first_name + ' ' + data.owner.last_name }}
                    </router-link>
                </p>
                <p class="mb-0">
                    <router-link :to="{name: 'post', params: {post: data.id}}" class="small date mr-1">{{ data.created_at | date }}</router-link>
                    <img :src="'/images/' + data.privacy + '.png'">
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
            <favorite :favoritableType="'post'" :favoritable="data" data-toggle="tooltip" data-placement="bottom" title="Favorites"></favorite>
            <span class="mr-4" data-toggle="tooltip" data-placement="bottom" title="Comments">
                <img src="/images/comment.png" class="post-action" @click="focusOnCommentsInput">
                <small>{{ commentsCount }}</small>
            </span>
            <span data-toggle="tooltip" data-placement="bottom" title="Shares">
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
    import Favorite from './Favorite.vue';

    export default {
        props: ['data'],

        components: {Carousel, EditPost, DeletePost, NewComment, CommentsList, Favorite},

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

        mounted() {
            $('[data-toggle="tooltip"]').tooltip();
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
