import { createRouter, createWebHistory } from 'vue-router';
import useAuth from '../composables/auth';

import HomePage from '../Components/HomePage.vue';
import Login from '../Pages/Auth/Login.vue';
import Register from '../Pages/Auth/Register.vue';
import ProfilePage from '../Pages/Profile/Edit.vue';
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import Edit from "@/Pages/Profile/Edit.vue";

const routes = [
    { path: '/', name: 'home', component: HomePage },
    { path: '/login', name: 'login', component: Login, meta: { guestOnly: true } },
    { path: '/register', name: 'register', component: Register, meta: { guestOnly: true } },
    { path: '/profile', name: 'profile', component: Edit, meta: { requiresAuth: true } },
    { path: '/profile/edit', name: 'profile.edit', component: UpdateProfileInformationForm, meta: { requiresAuth: true } },
    { path: '/profile/password', name: 'profile.password', component: UpdatePasswordForm, meta: { requiresAuth: true } },
    { path: '/profile/delete', name: 'profile.delete', component: DeleteUserForm, meta: { requiresAuth: true } },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const { auth, getAuth } = useAuth();
    if (auth.user === null) {
        await getAuth();
    }

    const isAuthenticated = !!auth.user;

    if (to.meta.requiresAuth && !isAuthenticated) {
        return next({ name: 'login' });
    }

    if (to.meta.guestOnly && isAuthenticated) {
        return next({ name: 'home' });
    }

    return next();
});

export default router;
