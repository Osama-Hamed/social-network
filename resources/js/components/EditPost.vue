<template>
    <div class="social-modal w-100 h-100">
        <div class="container">
            <div class="row">
                <div class="social-modal-content col-lg-6 offset-lg-3">
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <form @submit.prevent="update">
                                <div class="form-group mb-0">
                                    <social-textarea v-model="form.body" :initialRowsCount="4" :hasPadding="true" ref="socialTextarea"></social-textarea>
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
                                        <small class="font-weight-bold">Update</small>
                                    </button>

                                    <label for="edit-file-input" class="btn mb-0 action py-1">
                                        <img src="/images/upload.png" width="20" height="20" class="mr-1">
                                        <small class="font-weight-bold">Upload</small>
                                    </label>

                                    <input id="edit-file-input" type="file" @change="encodeImages('images', $event)" multiple>

                                    <select class="custom-select custom-select-sm w-25 ml-4" v-model="form.privacy">
                                        <option value="1" selected>Public</option>
                                        <option value="2">Friends</option>
                                        <option value="3">Private</option>
                                    </select>

                                    <button class="btn action mr-3 py-1 float-right" @click.prevent="$emit('cancel')">
                                        <small class="font-weight-bold">Cancel</small>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
        props: ['data'],

        components: {SocialTextarea},

        mixins: [ImagesHandler],

        data() {
            return {
                form: new Form({
                    body: '',
                    images: [],
                    privacy: '1'
                })
            }
        },

        created() {
            this.showPost();
        },

        mounted() {
            this.$refs.socialTextarea.focus();
        },

        methods: {
            showPost() {
                this.form.body = this.data.body;
                this.data.encodedImages.forEach((encodedImage) => this.form.images.push(encodedImage.encoded));
                if (this.data.privacy === 'public') this.form.privacy = '1';
                if (this.data.privacy === 'friends') this.form.privacy = '2';
                if (this.data.privacy === 'private') this.form.privacy = '3';
            },

            async update() {
                try {
                    const response = await this.form[api.post.update.method](api.post.update.url(this.data.id));
                    Event.fire('post-updated', response.data);
                } catch (error) {}
            },
        }
    }
</script>
