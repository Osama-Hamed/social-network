<template>
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-0 mb-4">
                <img src="images/avatar.png" class="card-img-top mx-auto d-block mt-4 big-profile-image">
                <div class="card-body text-center mt-2">
                    <a href="#" class="username font-weight-bold">#OSAMA_HAMED</a>
                    <p class="card-text mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <new-post></new-post>

            <posts-list></posts-list>
        </div>

        <div class="col lg-3">
            <div class="card border-0 mb-4">
                <h6 class="p-3 border-bottom mb-0">Friends Activity</h6>
                <div class="card-body p-3">
                    <div class="media mb-3">
                        <img src="images/avatar.png" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <a href="#" class="font-weight-bold">Osama</a> shared a new <a href="#">post</a>.
                        </div>
                    </div>

                    <div class="media mb-3">
                        <img src="images/avatar.png" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <a href="#" class="font-weight-bold">Osama</a> shared a new <a href="#">post</a>.
                        </div>
                    </div>

                    <div class="media">
                        <img src="images/avatar.png" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <a href="#" class="font-weight-bold">Osama</a> shared a new <a href="#">post</a>.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 mb-4">
                <h6 class="p-3 border-bottom mb-0">People You May Know</h6>
                <div class="card-body p-3">
                    <div class="media mb-3">
                        <img src="images/avatar.png" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <a href="#" class="font-weight-bold d-inline-block mt-1">Osama Hamed</a>
                            <img src="images/add.png" class="float-right" width="25" height="25">
                        </div>
                    </div>

                    <div class="media mb-3">
                        <img src="images/avatar.png" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <a href="#" class="font-weight-bold d-inline-block mt-1">Osama Hamed</a>
                            <img src="images/add.png" class="float-right" width="25" height="25">
                        </div>
                    </div>

                    <div class="media mb-3">
                        <img src="images/avatar.png" class="mr-2 small-profile-image">
                        <div class="media-body my-auto small">
                            <a href="#" class="font-weight-bold d-inline-block mt-1">Osama Hamed</a>
                            <img src="images/add.png" class="float-right" width="25" height="25">
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

    export default {
        components: {NewPost, PostsList}
    }
</script>