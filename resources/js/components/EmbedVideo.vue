<template>
  <div class="embed-video embed-video--16by9">
    <iframe loading="lazy" class="lozad" :data-src="src" frameborder="0" allowfullscreen allow="autoplay"></iframe>
 </div>
</template>

<script>
export default {
  props: {
    code: String,
    autoplay: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    src() {
      return this.addParameters(`https://www.youtube.com/embed/${this.code}`);
    }
  },
  methods: {
    // not needed at the moment
    transformLink() {
      let cleanVideoSrc = this.videoUrl.split("?")[0];
      cleanVideoSrc.replace(/watch?v=/gi, "embed/");
      const videoID = this.videoUrl.split("embed/")[1];
      return this.addParameters(cleanVideoSrc);
    },
    addParameters(src) {
      return `${src}?controls=0&showinfo=0&rel=0&autoplay=${
        this.autoplay ? 1 : 0
      }&loop=1&mute=1&playlist=${this.code}`;
    }
  }
};
</script>