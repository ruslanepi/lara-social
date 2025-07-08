<template>
    <article class="post">

        <div v-if="post.reposted_post" class="citate">
            <div class="title">{{ post.reposted_post.title }}</div>
            <img v-if="post.reposted_post.image_url" :src="post.reposted_post.image_url"
                 :alt="post.reposted_post.title">
            <div class="content">{{ post.reposted_post.content }}</div>
        </div>


        <div :class="['post-wrapper flex justify-end  w-full gap-4', post.reposted_post ? '' : '']">
            <div class=" title">{{ post.title }}</div>
            <img v-if="post.image_url" :src="post.image_url" :alt="post.title">
            <div class="content">{{ post.content }}</div>


            <div class="flex justify-end  w-full gap-4 ">

                <div class="flex ">
                    {{ post.likes_count }}
                    <svg @click.prevent="openRepost(post)" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"
                         :class="['size-6   stroke-sky-500 cursor-pointer hover:fill-sky-500 fill-white']"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z"/>
                    </svg>
                </div>
                <div class="flex ">
                    {{ post.likes_count }}
                    <svg @click.prevent="toggleLike(post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor"
                         :class="['size-6   stroke-sky-500 cursor-pointer hover:fill-sky-500', post.is_liked ? 'fill-sky-500' : 'fill-white']">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                    </svg>
                </div>


            </div>
        </div>


        <div class="date">{{ post.date }}</div>

        <div class="mt-5 w-full" v-if="is_repost">
            <div class="flex flex-col mb-5">
                <input class="flex bg-stone-100 p-3 mb-2 rounded-md" v-model="title" type="text"
                       placeholder="Title">
                <textarea class="flex bg-stone-100 p-3 rounded-md" v-model="content"
                          placeholder="Content"></textarea>
            </div>

            <div class="mb-5">
                <a class="bg-green-800 px-4 py-2 rounded-md mr-3 text-white" href="" @click.prevent="repost(post)">Процитировать</a>
            </div>

        </div>
    </article>
</template>


<script setup>
import axios from "axios";
import {ref} from "vue";

const props = defineProps(['post']);
const is_repost = ref('');
const reposted_id = ref('');

const title = ref('');
const content = ref('');


const toggleLike = (post) => {
    console.log(post);
    axios.post(`/api/posts/${post.id}/toggleLike`)
        .then(res => {
            post.is_liked = res.data.is_liked
            post.likes_count = res.data.likes_count
            console.log(res.data.is_liked)
        })
}

const openRepost = (post) => {
    console.log(post)
    is_repost.value = !is_repost.value;
}

const repost = (post) => {
    reposted_id.value = post.id
    axios.post(`/api/posts/${post.id}/repost`, {title: title.value, content: content.value})
        .then(res => {
            title.value = '';
            content.value = '';
        })

}
</script>

<style scoped>
.post {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}


.citate {
    background-color: #ececec;
    width: 50%;
    padding: 15px;
    border-radius: 20px;
    margin-bottom: 20px;
}

.post-wrapper {
    display: flex;
    flex-direction: column;
}
</style>
