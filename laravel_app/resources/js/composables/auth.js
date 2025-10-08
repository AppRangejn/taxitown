import { reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default function useAuth() {
    const router = useRouter();
    const auth = reactive({
        user: null,
    });

    const getAuth = async () => {
        try {
            const response = await axios.get('/user');
            auth.user = response.data;
        } catch (e) {
            auth.user = null;
        }
    }

    const logout = async () => {
        try {
            await axios.post('/logout');
        } finally {
            auth.user = null;
            window.location.href = "/";
        }
    }

    return { auth, getAuth, logout };
}
