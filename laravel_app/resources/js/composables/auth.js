import { reactive } from 'vue';
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8080';
axios.defaults.withCredentials = true; // важливо для Sanctum

const auth = reactive({
    user: null,
});

const initCsrf = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
    } catch (err) {
        console.warn('Не вдалося отримати CSRF cookie:', err);
    }
};

const updateUser = (newUserData) => {
    auth.user = newUserData ?? auth.user;
};

export default function useAuth() {
    const getAuth = async () => {
        try {
            await initCsrf();
            const res = await axios.get('/api/user');
            auth.user = res.data || null;
        } catch (err) {
            auth.user = null;
            console.warn(
                'Не вдалося отримати дані користувача:',
                err.response?.data?.message || err.message
            );
        }
        return auth.user;
    };

    const logout = async () => {
        try {
            await initCsrf();
            await axios.post('/logout');
        } catch (err) {
            console.warn(
                'Помилка при логауті:',
                err.response?.data?.message || err.message
            );
        } finally {
            auth.user = null;
            window.location.href = '/';
        }
    };

    const isAuthenticated = () => !!auth.user;

    // ✅ Єдиний правильний return:
    return { auth, getAuth, logout, initCsrf, isAuthenticated, updateUser };
}
