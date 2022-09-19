<template>
    <div class="morphing-headline">
        Just a blog about web dev and <br>
        <span v-text="item"></span>
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
            item: this.getRandomItem(),
            lastItem: null
        }
    },
    mounted() {
        setInterval(() => {
            this.lastItem = this.item;
            this.item = this.getRandomItem()
        }, 1500);
    },
    methods: {
        getRandomItem() {
            const filteredItems = items.filter(item => item !== this.lastItem)
                .filter(item => item !== this.lastItem);
            return filteredItems[Math.floor(Math.random() * filteredItems.length)];
        },
    }
};
</script>
