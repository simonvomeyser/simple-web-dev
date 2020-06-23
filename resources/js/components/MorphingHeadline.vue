<template>
    <div class="morphing-headline">
        Just a blog about web dev and <br> <span v-text="item"></span>
    </div>
</template>

<script>
const items = [
    "Laravel",
    "the frontend",
    "the backend",
    "PHP",
    "JavaScript",
    "bad jokes",
    "memes",
    "CSS",
    "projects",
    "communication",
    "fun",
    "teamwork",
    "productivity",
    "project management",
];

export default {
  data() {
    return {
      item: this.getRandomItem()
    }
  },
  mounted() {
    setInterval(() => {
      this.item = this.getRandomItem()
    }, 5000);
  },
  methods: {
    getRandomItem() {
      return items[Math.floor(Math.random() * items.length)];
    },
  }
};
</script>
