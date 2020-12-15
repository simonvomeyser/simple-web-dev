import lozad from 'lozad';
import Vue from 'vue';
import EmbedPlayground from './components/EmbedPlayground.vue';
import EmbedVideo from './components/EmbedVideo.vue';
import MorphingHeadline from './components/MorphingHeadline.vue';
import Sidenote from './components/Sidenote.vue';
import Tldr from "./components/Tldr";
import TldrLink from "./components/TldrLink";

new Vue({
    el: '#app',
    components: {
        EmbedVideo,
        EmbedPlayground,
        Sidenote,
        MorphingHeadline,
        Tldr,
        TldrLink
    }
});

// lazy loads images with .lozad
const observer = lozad();
observer.observe();
