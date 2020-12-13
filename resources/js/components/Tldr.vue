<template>
    <div class="tldr">
        <div class="tldr__info" :class="{'tldr__info--shown' : showInfo}">
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
import debounce from 'lodash/debounce';

export default {
    props: {
        buttonText: {
            type: String,
        }
    },
    data() {
        return {
            open: false,
            hideButton: false,
            showInfo: false
        }
    },
    mounted() {
        this.$root.$on('tldr', () => {
            this.openUp();
        });
        this.handleDebouncedScroll = debounce(this.handleScroll, 100);
        window.addEventListener('scroll', this.handleDebouncedScroll);
    },
    methods: {
        openUp() {
            this.open = true;
        },
        handleScroll() {
            this.showInfo = (window.scrollY > 50 && window.scrollY < 1000 );
        },
        beforeDestroy() {
            window.removeEventListener('scroll', this.handleDebouncedScroll);
        }
    }
};
</script>
