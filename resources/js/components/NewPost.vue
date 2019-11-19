<template>
    <div class="card mb-4">
        <div class="card-body p-0">
            <form @submit.prevent="publish">
                <div class="form-group mb-0">
                    <social-textarea v-model="form.body" :initialRowsCount="4" :hasPadding="true"></social-textarea>
                </div>

                <div class="card-body row" v-if="form.images.length">
                    <div class="col-lg-3 mb-2" v-for="(image, index) in form.images" :key="image.id">
                        <img :src="image" class="img-thumbnail img-fluid selected-image">
                        <span class="remove-image" @click="removeImage('images', index)">x</span>
                    </div>
                </div>

                <hr class="my-0">

                <div class="form-group pl-4 py-2 mb-0">
                    <button class="btn mr-3 action py-1">
                        <img src="/images/send.png" width="20" height="20" class="mr-1">
                        <small class="font-weight-bold">Post</small>
                    </button>

                    <label for="file-input" class="btn mb-0 action py-1">
                        <img src="/images/upload.png" width="20" height="20" class="mr-1">
                        <small class="font-weight-bold">Upload</small>
                    </label>

                    <input id="file-input" type="file" @change="encodeImages('images', $event)" multiple>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from '../shared/form';
    import SocialTextarea from './SocialTextarea';
    import api from '../shared/api';
    import ImagesHandler from '../mixins/ImagesHandler';
    import Event from '../shared/event';

    export default {
        components: {SocialTextarea},

        mixins: [ImagesHandler],

        data() {
            return {
                form: new Form({
                    body: '',
                    images: []
                })
            }
        },

        methods: {
            async publish() {
                try {
                    const response = await this.form[api.post.create.method](api.post.create.url());
                    Event.fire('post-created', response.data);
                } catch (error) {}
            },
        }
    }
</script>