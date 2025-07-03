<template>
    <article class="post">
        <div class="title">{{ post.title }}</div>
        <img v-if="post.image_url" :src="post.image_url" :alt="post.title">
        <div class="content">{{ post.content }}</div>
        <div class="flex justify-between items-center">
            {{post.likes_count}}
            <svg  @click.prevent="toggleLike(post)" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 :class="['size-6   stroke-sky-500 cursor-pointer hover:fill-sky-500', post.is_liked ? 'fill-sky-500' : 'fill-white']">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>

        </div>
        <div class="date">{{ post.date }}</div>
    </article>
</template>


<script setup>
import axios from "axios";
import Login from "@/views/Login.vue";

const props = defineProps(['post']);


const toggleLike = (post) => {
    console.log(post);
    axios.post(`/api/posts/${post.id}/toggleLike`)
        .then(res => {
            post.is_liked = res.data.is_liked
            post.likes_count = res.data.likes_count
            console.log(res.data.is_liked)
        })
}
</script>

<style scoped>
.post {
    display: flex;
    flex-direction: column;
}
</style>
