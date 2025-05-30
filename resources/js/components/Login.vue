<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="login">
            <input v-model="email" placeholder="Email" required type="email">
            <input v-model="password" type="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {useRouter} from "vue-router";
import axios from "axios";

const router = useRouter()
const email = ref('')
const password = ref('')

const login = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie',);
        const response = await axios.post('/api/auth/login', {
            email: email.value,
            password: password.value
        });

        if (response.status === 200) {
            localStorage.setItem('authenticated', 'true');
            await router.push('/dashboard');
        }
    } catch (error) {
        console.error('Login failed!', error.response?.data || error.message);
        alert('Login failed! Check console for details.');
    }


};
</script>
