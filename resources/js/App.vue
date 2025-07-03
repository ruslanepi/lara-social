<template>
    <div>
        <div class="flex p-5 gap-4 ">
            <router-link v-if="!isAuthenticated" to="/register">Регистрация</router-link>
            <router-link v-if="!isAuthenticated" to="/login">Войти</router-link>
            <router-link v-if="isAuthenticated" to="/index">Пользователи</router-link>
            <router-link v-if="isAuthenticated" :to="{name: 'Feed'}">Лента</router-link>
            <router-link v-if="isAuthenticated" to="/dashboard">Личный кабинет</router-link>
            <a v-if="isAuthenticated" class="cursor-pointer" @click="logout">Выйти</a>

        </div>
        <router-view/>
    </div>
</template>

<script setup>

import {ref} from "vue";
import axios from "axios";



const isAuthenticated = ref(false);

async function checkAuth() {
    try {
        if (!localStorage.getItem('authenticated')) {
            isAuthenticated.value = false;
            return;
        }


        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.get('/api/user', {withCredentials: true});
        isAuthenticated.value = response.status === 200;

    } catch (error) {
        isAuthenticated.value = false;
    }

}



const logout = async () => {
    try {
        await axios.post('/api/auth/logout');
        localStorage.removeItem('authenticated');
        await router.push('/login');
        isAuthenticated.value = false;
    } catch (error) {
        console.error(error.response?.data ?? error.message);
    }
}

checkAuth()

</script>

<style scoped>
nav {
    padding: 10px;
}
</style>
