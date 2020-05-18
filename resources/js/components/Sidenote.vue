<template>
  <div class="sidenote">
    <div class="sidenote__heading">{{heading}}</div>
    <div class="sidenote__content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    heading: String
  }
};
</script>