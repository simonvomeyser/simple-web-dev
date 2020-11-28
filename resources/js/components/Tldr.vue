<template>
    <div class="tldr">

        <div class="tldr__trigger" v-if="!hideButton">
            <button class="button button--secondary button--well-fed" @click="openUp">TL;DR?</button>
        </div>
        <div class="tldr__content" id="tldr" v-show="open">
            <h2>TL; DR</h2>
            <slot></slot>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        buttonText: {
            type: String,
        }
    },
    data() {
        return {
            open: false,
            hideButton: false
        }
    },
    mounted() {
        this.$root.$on('tldr', () => {
            this.openUp();
        });
    },
    methods: {
        openUp() {
            this.open = true;
            setTimeout(() => {
                this.hideButton = true;
                location.hash = "tldr";
            }, 250)
        }
    }
};
</script>
