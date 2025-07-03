<template>
    <div class="flex flex-col p-5">
        <router-link :to="{name: 'Index'}" class="btn">Назад</router-link>

        <h1 class="text-lg mt-5">Ваша лента постов</h1>


        <div class="w-2xl">

            <section class="posts" v-if="posts">
                <Post v-for="post in posts" :post="post"></Post>
            </section>


        </div>
    </div>
</template>

<script setup>
import Post from "@/components/Post.vue";

import axios from 'axios';
import {ref} from "vue";


const posts = ref([]);


const getPosts = () => {
    axios.get(`/api/users/following_posts`)
        .then(res => {
                console.log(res);
                posts.value = res.data.data;

            }
        )
}


getPosts(); // Получаем все посты пользователя при монтировании компонента

</script>


<style>

.hidden {
    visibility: hidden;
}

.title {
    font-weight: 500;
    font-size: 18px;
    margin-bottom: 15px;
}

img {
    margin-bottom: 15px;
    border-radius: 10px;
}

.post {
    margin-bottom: 20px;
    padding: 12px 0;
    border-bottom: 1px solid #e8e8e8;
}

.date {
    text-align: right;
    color: #939393;
    font-size: 14px;
}
</style>
