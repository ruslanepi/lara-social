<template>
    <div>
        <div class="flex p-5 gap-4">
            <router-link to="/register">Регистрация</router-link>
            <router-link to="/login">Войти</router-link>
            <router-link v-if="isAuthenticated" to="/dashboard">Личный кабинет</router-link>
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

checkAuth()

</script>

<style scoped>
nav {
    padding: 10px;
}
</style>
