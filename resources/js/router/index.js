import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../views/Dashboard.vue';
import Index from "../views/Index.vue";
import Show from "../views/Show.vue";
import Feed from "@/views/Feed.vue";

const routes = [
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/dashboard', name: 'Dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/index', name: 'Index', component: Index, meta: { requiresAuth: true } },
    { path: '/user/:id/show', name: 'ShowUser', component: Show, meta: { requiresAuth: true } },
    { path: '/user/feed', name: 'Feed', component: Feed, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Middleware для защиты маршрутов
router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('authenticated') === 'true';

    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login');
    } else {
        next();
    }
});

export default router;
