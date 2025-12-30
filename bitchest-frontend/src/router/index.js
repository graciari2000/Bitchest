import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../components/HomePage.vue';
import Login from '../components/LogIn.vue';
import Register from '../components/Register.vue';
import AdminDashboard from '../components/AdminDashboard.vue';
import UserDashboard from '../components/UserDashboard.vue';
import Wallet from '../components/Wallet.vue';
import Messages from '../components/Messages.vue';
import Trade from '../components/Trade.vue';
import UserSettings from '../components/UserSettings.vue'; // Add this import
import AdminSettings from '../components/AdminSettings.vue'; // Add this import

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
        {
            path: '/',
            name: 'Home',
            component: HomePage
        },
        {
            path: '/login',
            name: 'Login',
            component: Login,
            meta: { requiresGuest: true }
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
            meta: { requiresGuest: true }
        },
        {
            path: '/admin/dashboard',
            name: 'AdminDashboard',
            component: AdminDashboard,
            meta: { requiresAuth: true, requiresAdmin: true }
        },
        {
            path: '/dashboard',
            name: 'UserDashboard',
            component: UserDashboard,
            meta: { requiresAuth: true }
        },
        {
            path: '/user-dashboard',
            name: 'UserDashboardLegacy',
            component: UserDashboard,
            meta: { requiresAuth: true }
        },
        {
            path: '/wallet',
            name: 'Wallet',
            component: Wallet,
            meta: { requiresAuth: true }
        },
        {
            path: '/messages',
            name: 'Messages',
            component: Messages,
            meta: { requiresAuth: true }
        },
        {
            path: '/trade',
            name: 'Trade',
            component: Trade,
            meta: { requiresAuth: true }
        },
        {
            path: '/settings',
            name: 'UserSettings',
            component: UserSettings,
            meta: { requiresAuth: true }
        },
        {
            path: '/admin/settings',
            name: 'AdminSettings',
            component: AdminSettings,
            meta: { requiresAuth: true, requiresAdmin: true }
        },
        // fallback: redirect unknown paths to home (prevents "No match found" warnings)
        { path: '/:pathMatch(.*)*', redirect: '/' }
    ]
});

// Navigation guard pour vérifier l'authentification
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    let user = null;

    try {
        const userStr = localStorage.getItem('user');
        if (userStr) {
            user = JSON.parse(userStr);
        }
    } catch (e) {
        console.error('Error parsing user from localStorage:', e);
    }

    // Si la route nécessite une authentification
    if (to.meta.requiresAuth) {
        if (!token || !user) {
            // Clear any invalid data
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            // Rediriger vers login si non authentifié
            next('/login');
            return;
        } else if (to.meta.requiresAdmin && user.role !== 'admin') {
            // Rediriger vers dashboard si l'utilisateur n'est pas admin
            next('/dashboard');
            return;
        } else {
            next();
            return;
        }
    }
    // Si la route nécessite d'être invité (non connecté)
    else if (to.meta.requiresGuest) {
        if (token && user) {
            // Rediriger vers le dashboard approprié si déjà connecté
            if (user.role === 'admin') {
                next('/admin/dashboard');
            } else {
                next('/dashboard');
            }
        } else {
            next();
        }
    }
    // Routes publiques
    else {
        next();
    }
});

export default router;