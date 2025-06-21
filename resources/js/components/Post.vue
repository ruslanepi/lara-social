<template>
    <article class="post">
        <div class="title">{{ post.title }}</div>
        <img v-if="post.image_url" :src="post.image_url" :alt="post.title">
        <div class="content">{{ post.content }}</div>
        <div class="date">{{ post.date }}</div>
    </article>
</template>


<script setup>
const props = defineProps(['post']);
</script>

<style scoped>

</style>
