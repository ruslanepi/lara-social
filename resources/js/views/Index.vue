<template>
    <div class="container">
        <h1>Users</h1>
        <div v-if="users" class="users">
            <article v-for="user in users">
                <div>
                    <p>{{ user.id }}</p>
                    <p>{{ user.email }}</p>
                    <p>{{ user.name }}</p>
                    <p>Постов: {{ user.posts_count }}</p>
                    <router-link :to="{name: 'ShowUser', params:{id:user.id}}" class="btn">Подробнее</router-link>
                </div>
                <div v-if="!user.is_followed">
                    <div @click.prevent="toggleSubscribe(user)" class="btn">Подписаться </div>
                </div>

                <div v-if="user.is_followed">
                    <div @click.prevent="toggleSubscribe(user)" class="btn">Отписаться </div>
                </div>
            </article>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";

import axios from "axios";

const users = ref([]);

const getUsers = () => {
    axios.get('/api/users/')
        .then(res => {
            console.log(res.data)
            users.value = res.data.data
        })
}


const toggleSubscribe = (user) => {
    axios.post(`/api/users/${user.id}/toggleSubscribe`)
        .then(res => {
            user.is_followed = res.data.is_followed
            console.log(res.data.is_followed)
            console.log(users.value)
        })
}

getUsers()

</script>

<style>

.container {
    margin: 0 20px;

    h1 {
        margin-bottom: 30px;
        font-weight: bold;
    }
}

article {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #ccc;

    display: flex;

    justify-content: space-between;
    align-items: flex-end;
}

.btn {
    border-radius: 10px;
    border: 1px solid #2d3748;
    padding: 6px 20px;
    display: block;
    width: fit-content;
    margin-top: 10px;
    cursor: pointer;

    &:hover {
        background-color: #2d3748;
        color: #fff;
    }
}
</style>
