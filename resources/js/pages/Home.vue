<template>
    <div class="row">
        <div class="col-lg-3">
            <div class="card mb-4">
                <img :src="authAvatar" class="card-img-top mx-auto d-block mt-4 big-profile-image">
                <div class="card-body text-center mt-2">
                    <router-link :to="{name: 'profile', params: {username: authName}}" 
                        class="username font-weight-bold">
                        {{ authName }}
                    </router-link>
                    <p class="card-text mt-2">{{ authBio }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <new-post></new-post>

            <posts-list :posts="posts" v-if="isReady"></posts-list>
            <p class="font-weight-bold text-center" v-if="posts.length == 0">
                There is no posts yet,
                add friends to see their posts.
            </p>
        </div>

        <div class="col lg-3">
            <div class="card mb-4" v-if="activities.length > 0">
                <h6 class="p-3 border-bottom mb-0">Friends Activity</h6>
                <div class="card-body p-3 activity-panel">
                    <div class="media mb-3" v-for="activity in activities">
                        <img :src="activity.maker.avatarPath" class="mr-2 small-profile-image">

                        <div class="media-body my-auto small" v-if="activity.type == 'created_post'">
                            <router-link class="font-weight-bold" :to="{name: 'profile', params: {username: activity.maker.username}}">{{ activity.maker.first_name }}</router-link>
                            published a new
                            <router-link :to="{name: 'post', params: {post: activity.subject.id}}" class="font-weight-bold">post</router-link>
                        </div>

                        <div class="media-body my-auto small" v-if="activity.type == 'updated_post'">
                            <router-link class="font-weight-bold" :to="{name: 'profile', params: {username: activity.maker.username}}">{{ activity.maker.first_name }}</router-link>
                            updated a
                            <router-link :to="{name: 'post', params: {post: activity.subject.id}}" class="font-weight-bold">post</router-link>
                        </div>

                        <div class="media-body my-auto small" v-if="activity.type == 'created_comment'">
                            <router-link class="font-weight-bold" :to="{name: 'profile', params: {username: activity.maker.username}}">{{ activity.maker.first_name }}</router-link>
                            commented on a
                            <router-link :to="{name: 'post', params: {post: activity.subject.post_id}}" class="font-weight-bold">post</router-link>
                        </div>

                        <div class="media-body my-auto small" v-if="activity.type == 'updated_comment'">
                            <router-link class="font-weight-bold" :to="{name: 'profile', params: {username: activity.maker.username}}">{{ activity.maker.first_name }}</router-link>
                            updated comment on
                            <router-link :to="{name: 'post', params: {post: activity.subject.post_id}}" class="font-weight-bold">post</router-link>
                        </div>

                        <div class="media-body my-auto small" v-if="activity.type == 'created_favorite'">
                            <router-link class="font-weight-bold" :to="{name: 'profile', params: {username: activity.maker.username}}">{{ activity.maker.first_name }}</router-link>
                            favorited a
                            <router-link :to="{name: 'post', params: {post: activity.subject.favoritable_id}}" class="font-weight-bold" v-if="activity.subject.favoritable_type === 'App\\Post'">post</router-link>
                            <span v-if="activity.subject.favoritable_type === 'App\\Comment'">
                                comment on 
                                <router-link :to="{name: 'post', params: {post: activity.subject.favoritable.post_id}}" class="font-weight-bold">post</router-link>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4" v-if="friendsOfFriends.length > 0">
                <h6 class="p-3 border-bottom mb-0">People You May Know</h6>
                <div class="card-body p-3">
                    <div class="media mb-3" v-for="(fof, index) in friendsOfFriends">
                        <img :src="fof.avatarPath" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <router-link :to="{name: 'profile', params: {username: fof.username}}" class="font-weight-bold d-inline-block mt-1">
                                {{ fof.first_name + ' ' + fof.last_name }}
                            </router-link>
                            <button class="float-right btn btn-sm action py-0" @click="sendFriendRequest(fof.username, index)">add friend</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NewPost from '../components/NewPost.vue';
    import PostsList from '../components/PostsList.vue';
    import api from '../shared/api';

    export default {
        components: {NewPost, PostsList},

        data() {
            return {
                posts: [],
                totalPostsCount: 0,
                skip: 0,
                take: 10,
                activities: [],
                friendsOfFriends: [],
                isReady: false
            }
        },

        created() {
            this.fetchPosts();
            this.fetchActivities();
            this.fetchFriendsOfFriends();
            let vm = this;
            setInterval(() => {vm.fetchActivities()}, 60000);

            window.addEventListener('scroll', (e) => {
                if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight && this.skip < this.totalPostsCount) {
                    this.fetchPosts();
                }
            })
        },

        methods: {
            async fetchPosts() {
                try {
                    const response = await axios[api.post.all.method](api.post.all.url(), {
                        params: {
                            skip: this.skip,
                            take: this.take
                        }
                    });
                    response.data.posts.forEach(post => this.posts.push(post));
                    this.totalPostsCount = response.data.totalPostsCount;
                    this.skip = this.posts.length;
                    this.isReady = true;
                } catch (error) {}
            },

            async fetchActivities() {
                try {
                    const response = await axios[api.activity.all.method](api.activity.all.url());
                    this.activities = response.data;
                } catch (error) {}
            },

            async fetchFriendsOfFriends() {
                try {
                    const response = await axios[api.friendOfFriend.all.method](api.friendOfFriend.all.url());
                    this.friendsOfFriends = response.data;
                } catch (error) {}
            },

            async sendFriendRequest(username, index) {
                try {
                    const response = await axios[api.friendship.create.method](api.friendship.create.url(), {username: username});
                    this.friendsOfFriends.splice(index, 1);
                } catch (error) {}
            }
        },

        computed: {
            authAvatar() {
                return window.authUser.avatarPath;
            },

            authName() {
                return window.authUser.username;
            },

            authBio() {
                return window.authUser.bio;
            }
        }
    }
</script>