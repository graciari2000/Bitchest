import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../components/HomePage.vue';
import Login from '../components/LogIn.vue';
import Register from '../components/Register.vue';

// safe BASE_URL fallback for different build environments
let BASE_URL = '/';
try {
    // prefer ESM import.meta when available (will throw in environments without import.meta)
    if (import.meta && import.meta.env && import.meta.env.BASE_URL) {
        BASE_URL = import.meta.env.BASE_URL;
    }
} catch (e) {
    // import.meta not available in this environment
}
// fallback to Node-style environment variable if present
if (typeof process !== 'undefined' && process.env && process.env.BASE_URL) {
    BASE_URL = process.env.BASE_URL;
}

const router = createRouter({
    history: createWebHistory(BASE_URL),
    routes: [
    { path: '/', name: 'Home', component: HomePage },
    { path: '/login', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },

    // fallback: redirect unknown paths to home (prevents "No match found" warnings)
    { path: '/:pathMatch(.*)*', redirect: '/' }
]
});

export default router;