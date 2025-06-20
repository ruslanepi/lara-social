<template>
    <div class="flex flex-col p-5">
        <h1 class="text-lg">Ваш личный кабинет</h1>


        <div class="w-2xl">
            <div class="mb-5">
                <p v-if="user.name ">Добро пожаловать, {{ user.name }}!</p>
                <p v-else>загрузка...</p>
            </div>
            <div class="flex flex-col mb-5">
                <input class="flex bg-stone-100 p-3 mb-2 rounded-md" v-model="title" type="text" placeholder="Title">
                <textarea class="flex bg-stone-100 p-3 rounded-md" v-model="content" placeholder="Content"></textarea>
            </div>

            <div class="mb-5 ">
                <input @change="storeImage" ref="file" type="file" class="hidden">
                <a class="bg-green-400 px-4 py-2 rounded-md mr-3 text-white " href="#" @click.prevent="selectFile()">Загрузить
                    изображение</a>
                <a class="bg-red-400 px-4 py-2 rounded-md text-white" v-if="image" href="#"
                   @click.prevent="cancelImage()">Отменить</a>
            </div>
            <div>
                <img v-if="image" :src="image.url" alt="Uploaded image">
            </div>

            <div class="mb-5">
                <a class="bg-green-800 px-4 py-2 rounded-md mr-3 text-white" href="" @click.prevent="publishPost">Опубликовать</a>
            </div>


            <section class="posts" v-if="posts">
                <article class="post" v-for="post in posts">
                    <div class="title">{{post.title}}</div>

                    <img v-if="post.image_url" :src="post.image_url" :alt="post.title">
                    <div class="content">{{post.content}}</div>
                    <div class="date">{{post.date}}</div>
                </article>
            </section>


            <div class="mt-100">
                <button class="cursor-pointer mr-5" @click="getUser">Показать пользователя</button>
                <button class="cursor-pointer" @click="logout">Выйти</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";

const router = useRouter()
const title = ref('')
const content = ref('')
const file = ref('')
const image = ref('')
const posts = ref([]);

const user = reactive({
    name: '',
})

const selectFile = () => {
    file.value.click();
};

const storeImage = (event) => {
    const selectedFile = event.target.files[0];
    if (selectedFile) {
        const formData = new FormData()
        formData.append('image', selectedFile)

        axios.post('/api/post_images', formData)
            .then(res => {
                image.value = res.data.data;
                console.log(image.value)
            })
    }
};

const cancelImage = () => {
    image.value = '';
}
const publishPost = async () => {
    const id = image.value ? image.value.id : null
    await axios.post('/api/posts', {title: title.value, content: content.value, image_id: id})
        .then(res => {


            title.value = '';
            content.value = '';
            image.value = null;
            console.log(res);

            posts.value.unshift(res.data.data)
        })
}
const logout = async () => {
    try {
        await axios.post('/api/auth/logout');
        localStorage.removeItem('authenticated');
        await router.push('/login');
    } catch (error) {
        console.error(error.response?.data ?? error.message);
    }
}

const getUser = async () => {
    try {
        const response = await axios.get('/api/user');
        Object.assign(user, response.data);
        console.log('Authenticated user:', response.data);
    } catch (error) {
        console.error('User not authenticated', error.response?.data ?? error.message);
    }
}

const getPosts = () => {
    axios.get('/api/posts')
        .then(res => {
            console.log(res);
            posts.value = res.data.data;
            }
        )
}


getUser(); // Получаем пользователя при монтировании компонента
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
