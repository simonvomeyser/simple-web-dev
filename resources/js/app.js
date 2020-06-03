import lozad from 'lozad';
import Vue from 'vue';
import EmbedPlayground from './components/EmbedPlayground.vue';
import EmbedVideo from './components/EmbedVideo.vue';
import Sidenote from './components/Sidenote.vue';



new Vue({
    el: '#app',
    components: {
        EmbedVideo,
        EmbedPlayground,
        Sidenote
    }
});

// lazy loads elements with selector as '.lazing-loading-image'
const observer = lozad();
observer.observe();
