import Vue from 'vue';
import EmbedPlayground from './components/EmbedPlayground.vue';
import EmbedVideo from './components/EmbedVideo.vue';

new Vue({
    el: '#app',
    components: {
        EmbedVideo,
        EmbedPlayground,
    }
});

