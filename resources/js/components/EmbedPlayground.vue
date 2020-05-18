<template>
  <div class="embed-playground">
    <iframe
      :src="src"
      scrolling="no"
      frameborder="0"
      height="365"
      allowtransparency="true"
      allowfullscreen="true"
      allowpaymentrequest="true"
      loading="lazy"
    />
  </div>
</template>

<script>
export default {
  props: {
    src: String
  }
};
</script>