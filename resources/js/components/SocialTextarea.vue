<template>
    <textarea
        class="form-control w-100 shadow-none"
        placeholder="Have something to say..."
        :class="{ 'p-3': hasPadding, 'border-0': !hasBorder }"
        :style="{ height: height }"
        :rows="rowsCount"
        :value="value"
        @input="onInput($event)"></textarea>
</template>

<script>
    export default {
        props: ['value', 'initialRowsCount', 'hasPadding', 'hasBorder'],

        data() {
            return {
                rowsCount: 0,
                height: 'auto',
                heightReduction: 0
            }
        },

        created() {
            if (this.hasBorder) this.heightReduction = 2;

            this.resize();
        },

        watch: {
            value(value) {
                if (value === '') this.resize();
            }
        },

        methods: {
            onInput(e) {
                this.$emit('input', e.target.value);

                this.resize();
            },

            resize() {
                this.rowsCount = this.initialRowsCount;
                this.height = 'auto';

                this.$nextTick(() => this.height = this.$el.scrollHeight + this.heightReduction + 'px');
            },

            focus() {
                this.$el.focus();
            }
        }
    }
</script>
