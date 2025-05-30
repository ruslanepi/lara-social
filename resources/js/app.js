import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import axios from 'axios';

// Настройка axios
axios.defaults.baseURL = 'http://127.0.0.1:8000'; // Убедись, что это твой адрес Laravel сервера
axios.defaults.withCredentials = true; // Очень важно для Sanctum!

// Создание Vue приложения
const app = createApp(App);

// Подключение роутера
app.use(router);

// Присваиваем axios глобально, чтобы можно было использовать через this.$axios
app.config.globalProperties.$axios = axios;

// Монтируем приложение
app.mount('#app');
