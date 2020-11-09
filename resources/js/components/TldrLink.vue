<template>
    <a href="#" @click.prevent="emit">
        <slot></slot>
    </a>
</template>

<script>
export default {
    methods: {
        emit() {
            this.$root.$emit('tldr');
        }
    }
};
</script>
