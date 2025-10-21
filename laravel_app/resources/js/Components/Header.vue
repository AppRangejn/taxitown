<template>
    <header class="bg-gradient-to-r from-gray-900 to-black shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <router-link to="/" class="flex items-center space-x-2 group">
                    <img src="/taxi-icon.png" alt="TaxiTown Logo" class="h-10 w-10 drop-shadow-md" />
                    <span
                        class="text-2xl font-extrabold text-yellow-400 tracking-tight group-hover:text-yellow-300 transition-colors duration-300"
                    >
                        TaxiTown
                    </span>
                </router-link>

                <nav class="flex items-center space-x-4 sm:space-x-8">
                    <router-link
                        to="/"
                        class="text-gray-300 hover:text-yellow-400 transition-all duration-300 font-semibold text-lg tracking-wide hover:scale-105"
                    >
                        Головна
                    </router-link>

                    <template v-if="!auth.user">
                        <router-link to="/login" class="btn-outline">
                            Увійти
                        </router-link>

                        <router-link to="/register" class="btn-glow">
                            Реєстрація
                        </router-link>
                    </template>

                    <template v-else>
                        <router-link to="/profile" class="btn-profile">
                            {{ auth.user.name }}
                        </router-link>

                        <button @click="logout" class="btn-danger">
                            Вийти
                        </button>
                    </template>

                    <button
                        @click="toggleTheme"
                        class="ml-3 p-2 rounded-full bg-gray-800 text-yellow-400 hover:bg-yellow-400 hover:text-black transition-all duration-300 shadow-md hover:shadow-yellow-400/30 hover:scale-110"
                    >
                        <svg
                            v-if="theme === 'light'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 3v1m0 16v1m8.66-15.66l-.7.7M4.04 19.96l-.7.7M21 12h-1M4 12H3m16.66 4.34l-.7-.7M5.04 5.04l-.7-.7"
                            />
                        </svg>
                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                            />
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
        const theme = ref(localStorage.getItem('theme') || 'light');

        const applyTheme = () => {
            if (theme.value === 'dark')
                document.documentElement.classList.add('dark');
            else
                document.documentElement.classList.remove('dark');
        };

        const toggleTheme = () => {
            theme.value = theme.value === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', theme.value);
            applyTheme();
        };

        onMounted(() => {
            getAuth();
            applyTheme();
        });

        return { auth, logout, theme, toggleTheme };
    },
};
</script>

<style scoped>
.bg-gradient-to-r {
    background: linear-gradient(to right, #0d0d0d, #1a1a1a, #000000);
}

.btn-glow {
    @apply relative overflow-hidden px-6 py-2 rounded-full font-bold tracking-wide text-black bg-yellow-400 shadow-lg transition-all duration-300;
}
.btn-glow:hover {
    background: linear-gradient(90deg, #facc15, #fbbf24);
    box-shadow: 0 0 20px rgba(250, 204, 21, 0.6), 0 0 40px rgba(250, 204, 21, 0.3);
    transform: scale(1.08);
}

.btn-outline {
    @apply relative overflow-hidden px-6 py-2 rounded-full font-bold tracking-wide border-2 transition-all duration-300;
    color: #facc15;
    border-color: #facc15;
}
.btn-outline:hover {
    background: #facc15;
    color: #111;
    box-shadow: 0 0 15px rgba(250, 204, 21, 0.6);
    transform: scale(1.08);
}

.btn-profile {
    @apply px-5 py-2 rounded-full font-semibold text-yellow-300 bg-gray-800 hover:bg-yellow-400 hover:text-black transition-all duration-300 shadow-md;
}
.btn-profile:hover {
    transform: scale(1.07);
    box-shadow: 0 0 15px rgba(250, 204, 21, 0.5);
}

.btn-danger {
    @apply px-5 py-2 rounded-full font-semibold text-white bg-red-600 hover:bg-gradient-to-r hover:from-red-500 hover:to-yellow-400 transition-all duration-300 shadow-md;
}
.btn-danger:hover {
    transform: scale(1.07);
    box-shadow: 0 0 18px rgba(255, 100, 100, 0.5);
}

nav a,
nav button {
    transition: all 0.25s ease;
}
nav a:hover,
nav button:hover {
    transform: scale(1.05);
}
</style>
