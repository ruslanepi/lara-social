<template>
    <div class="container">
        <h1>Register</h1>
        <form @submit.prevent="register">
            <input v-model="name" type="text" placeholder="Name" required>
            <input v-model="email" type="email" placeholder="Email" required>
            <input v-model="password" type="password" placeholder="Password" required>
            <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/api/auth/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                });

                if (response.status === 200) {
                    alert('Registration successful!');
                    this.$router.push('/login');
                }
            } catch (error) {
                alert('Registration failed!');
            }
        }
    }
};
</script>


<style>

form {
    display: flex;
    flex-direction: column;
    gap: 8px;

    input {
        border: 1px solid #ccc;
        width: 300px;
        padding: 6px 12px;

    }

    button {
        width: 300px;
        background: #ccc;
        cursor: pointer;
        padding: 6px 12px;

        &:hover {
            background-color: #616161;
            color:#fff;
        }
    }
}

.container {
    padding: 20px;
}
</style>
