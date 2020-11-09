<template>
    <div class="tldr">

        <div class="tldr__trigger" v-if="!hideButton">
            <button class="button button--primary button--well-fed" @click="openUp"><span v-if="!open">TLDR:</span>&nbsp;{{ computedButtonText }}
            </button>
        </div>
        <div class="tldr__content"  id="tldr" v-show="open">
            <h2>TL; DR</h2>
            <slot></slot>
        </div>
    </div>
</template>

<script>

const buttonTextJokes = [
    'In a hurry?',
    'Too much text?',
    'Just tell me what do do!',
    'No time to read?',
    'No time to read?',
];

export default {
    props: {
        buttonText: {
            type: String,
            default: buttonTextJokes[Math.floor(Math.random() * buttonTextJokes.length)]
        }
    },
    data() {
        return {
            open: false,
            hideButton: false
        }
    },
    computed: {
        computedButtonText() {
            return this.open ? 'Okay okay!' : this.buttonText
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
            }, 1000)
        }
    }
};
</script>
