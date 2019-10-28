<template>
    <div class="card border-0 mb-4 pb-4">
        <div class="media mx-4 mt-3">
            <img src="images/avatar.png" class="mr-3 medium-profile-image">
            <div class="media-body my-auto">
                <p class="mb-0 ">
                    <a href="#" class="font-weight-bold username">{{ data.owner.first_name + ' ' + data.owner.last_name
                        }}</a>
                </p>
                <p class="mb-0">
                    <a href="#" class="small date">{{ data.created_at | date }}</a>
                </p>
            </div>
        </div>

        <div class="card-body pt-3 pb-0">
            <p class="card-text post-content" v-text="data.body"></p>
        </div>

        <carousel v-if="data.images.length" :srcs="data.images"></carousel>

        <div class="media mx-4 mt-3">
            <img src="images/avatar.png" class="mr-3 small-profile-image">
            <div class="media-body my-auto">
                <textarea rows="1" class="form-control" placeholder="Have something to say..."></textarea>
            </div>
        </div>

        <div class="comments">
            <div class="comment mx-4 px-3">
                <div class="media mt-3 py-2">
                    <img src="images/avatar.png" class="mr-3 small-profile-image">
                    <div class="media-body my-auto">
                        <p class="mb-0 ">
                            <a href="#" class="font-weight-bold username small">Osama Hamed</a>
                            <a href="#" class="small date">5 days ago.</a>
                        </p>
                        <p class="mb-0 comment-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad alias animi autem et eveniet excepturi.</p>
                    </div>
                </div>
            </div>
            <div class="comment mx-4 px-3">
                <div class="media mt-3 py-2">
                    <img src="images/avatar.png" class="mr-3 small-profile-image">
                    <div class="media-body my-auto">
                        <p class="mb-0 ">
                            <a href="#" class="font-weight-bold username small">Osama Hamed</a>
                            <a href="#" class="small date">5 days ago.</a>
                        </p>
                        <p class="mb-0 comment-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad alias animi autem et eveniet excepturi.</p>
                    </div>
                </div>
            </div>
            <div class="comment mx-4 px-3">
                <div class="media mt-3 py-2">
                    <img src="images/avatar.png" class="mr-3 small-profile-image">
                    <div class="media-body my-auto">
                        <p class="mb-0 ">
                            <a href="#" class="font-weight-bold username small">Osama Hamed</a>
                            <a href="#" class="small date">5 days ago.</a>
                        </p>
                        <p class="mb-0 comment-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad alias animi autem et eveniet excepturi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Carousel from './Carousel.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: {Carousel},

        filters: {
            date(value) {
                return moment(value).format('LLL');
            }
        }
    }
</script>