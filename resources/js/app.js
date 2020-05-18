import Vue from 'vue';
import EmbedPlayground from './components/EmbedPlayground.vue';
import EmbedVideo from './components/EmbedVideo.vue';
import Sidenote from './components/Sidenote.vue';

new Vue({
    el: '#app',
    components: {
        EmbedVideo,
        EmbedPlayground,
        Sidenote,
    }
});

