<template>
    <div class="tldr" data-close>
        <div class="tldr__info" :class="{'tldr__info--shown' : showInfo && !open}">
            <div class="tldr-info">
                <div class="tldr-info__heading">In a hurry?</div>
                <div class="tldr-info__copy">This post <br> has a short summary!</div>
                <div class="tldr-info__button">
                    <button class="button button--understatement" @click="open = true">
                        TLDR
                    </button>
                </div>
            </div>
        </div>
        <transition name="modal">
        <div class="tldr__modal" v-show="open">
            <div class="tldr-modal">
                <div class="tldr-modal__content">
                    <button class="tldr-modal__close" @click="open = false">&times;</button>
                    <h2>Summary</h2>
                    <slot></slot>
                </div>
            </div>
        </div>
        </transition>
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
            this.open = true;
        });

        if(window.location.hash === '#tldr') {
            this.open = true;
        }

        this.handleDebouncedScroll = debounce(this.handleScroll, 100);
        window.addEventListener('scroll', this.handleDebouncedScroll);
        window.addEventListener('keydown', this.handleKeydown);

    },
    methods: {
        handleScroll() {
            this.showInfo = (window.scrollY > 50 && window.scrollY < 1000 );
        },
        handleKeydown(e) {
            if(e.key === "Escape") {
               this.open = false;
            }
        },
        beforeDestroy() {
            window.removeEventListener('scroll', this.handleDebouncedScroll);
            window.removeEventListener('keydown', this.handleKeydown);
        }
    }
};
</script>
