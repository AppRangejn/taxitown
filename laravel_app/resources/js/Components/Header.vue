<template>
    <header class="bg-white shadow-md dark:bg-gray-800">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <router-link to="/" class="text-xl font-bold text-gray-800 dark:text-white">
                    TaxiTown
                </router-link>
                <nav class="flex items-center space-x-6">
                    <router-link to="/" class="text-gray-600 dark:text-gray-300 hover:text-blue-500 transition-colors duration-300">
                        Головна
                    </router-link>
                    <template v-if="!auth.user">
                        <router-link to="/login" class="px-5 py-2 text-blue-500 border border-blue-500 rounded-md hover:bg-blue-500 hover:text-white transition-colors duration-300">
                            Увійти
                        </router-link>
                        <router-link to="/register" class="px-5 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-300">
                            Реєстрація
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link
                            to="/profile"
                            class="px-4 py-2 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-300"
                        >
                            {{ auth.user.name }}
                        </router-link>
                        <button @click="logout" class="px-5 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-300">
                            Вийти
                        </button>
                    </template>
                    <button @click="toggleTheme" class="p-2 rounded-full focus:outline-none bg-gray-200 dark:bg-gray-700">
                        <svg v-if="theme === 'light'" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-15.66l-.7.7M4.04 19.96l-.7.7M21 12h-1M4 12H3m16.66 4.34l-.7-.7M5.04 5.04l-.7-.7" />
                        </svg>
                        <svg v-else class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </header>
</template>

<script>
import { ref, onMounted } from 'vue';
import useAuth from '../composables/auth';

export default {
    name: 'AppHeader',
    setup() {
        const { auth, getAuth, logout } = useAuth();
        const theme = ref('light');
        const applyTheme = () => {
            if (theme.value === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        };
        const toggleTheme = () => {
            theme.value = theme.value === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', theme.value);
            applyTheme();
        };
        onMounted(() => {
            getAuth();
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                theme.value = savedTheme;
            }
            applyTheme();
        });
        return { auth, logout, theme, toggleTheme };
    },
}
</script>
