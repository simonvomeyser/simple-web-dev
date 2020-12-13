<template>
    <div class="tldr">
        <div class="tldr__info">
            <div class="tldr-info">
                <div class="tldr-info__heading">In a hurry?</div>
                <div class="tldr-info__copy">This post <br> has a short summary!</div>
                <div class="tldr-info__button">
                    <button class="button button--understatement">
                        TLDR
                    </button>
                </div>
            </div>
        </div>
        <div class="tldr__content" id="tldr" v-show="open">
            <h2>Summary</h2>
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
