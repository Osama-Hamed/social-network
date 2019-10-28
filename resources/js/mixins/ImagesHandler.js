export default {
	methods: {
		encodeImages(field, e) {
            let files = e.target.files;
            if (!files.length) return;

            for (let i = 0; i < files.length; i++) {
                let reader = new FileReader();
                reader.onload = e => this.addImage(field, e.target.result);
                reader.readAsDataURL(files[i]);
            }
        },

        addImage(field, image) {
            this.form[field].push(image);
        },

        removeImage(field, index) {
            this.form[field].splice(index, 1);
        }
	}
}