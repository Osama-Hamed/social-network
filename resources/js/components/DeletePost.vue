<template>
    <div class="social-modal w-100 h-100">
        <div class="container">
            <div class="row">
                <div class="social-modal-content col-lg-6 offset-lg-3">
                    <div class="card border-0">
                        <div class="card-body">
                            <p class="lead">Are you sure you want to delete this post?</p>
                            <button class="btn action" @click="destroy">
                                <img src="/images/send.png" width="20" height="20" class="mr-1">
                                <small class="font-weight-bold">Delete</small>
                            </button>
                            <button class="btn action float-right" @click.prevent="$emit('cancel')">
                                <small class="font-weight-bold">Cancel</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../shared/api';
    import Event from '../shared/event';

    export default {
        props: ['id'],

        methods: {
            async destroy() {
                try {
                    const response = await axios[api.deletePost.method](api.deletePost.url(this.id));
                    Event.fire('post-deleted', this.id);
                } catch (error) {}
            },
        }
    }
</script>
