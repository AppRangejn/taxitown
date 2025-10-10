<template>
    <header class="bg-gradient-to-r from-gray-900 to-black shadow-lg">
        <div class="container mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <router-link to="/" class="flex items-center space-x-2">
                    <img src="/taxi-icon.png" alt="TaxiTown Logo" class="h-10 w-10" />
                    <span class="text-2xl font-extrabold text-yellow-400 tracking-tight">
                        TaxiTown
                    </span>
                </router-link>

                <!-- Navigation -->
                <nav class="flex items-center space-x-4 sm:space-x-8">
                    <router-link
                        to="/"
                        class="text-gray-300 hover:text-yellow-400 transition-colors duration-300 font-medium text-lg"
                    >
                        Головна
                    </router-link>

                    <!-- Authenticated User Links -->
                    <template v-if="!auth.user">
                        <router-link
                            to="/login"
                            class="px-4 py-2 text-yellow-400 border border-yellow-400 rounded-full hover:bg-yellow-400 hover:text-black transition-all duration-300 font-medium"
                        >
                            Увійти
                        </router-link>
                        <router-link
                            to="/register"
                            class="px-4 py-2 bg-yellow-400 text-black rounded-full hover:bg-yellow-500 transition-all duration-300 font-medium"
                        >
                            Реєстрація
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link
                            to="/profile"
                            class="flex items-center space-x-2 px-4 py-2 text-gray-200 bg-gray-800 rounded-full hover:bg-gray-700 transition-all duration-300"
                        >
                            <span class="font-medium">{{ auth.user.name }}</span>
                        </router-link>
                        <button
                            @click="logout"
                            class="px-4 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-all duration-300 font-medium"
                        >
                            Вийти
                        </button>
                    </template>

                    <!-- Theme Toggle Button -->
                    <button
                        @click="toggleTheme"
                        class="p-2 rounded-full bg-gray-800 hover:bg-gray-700 transition-all duration-300 focus:outline-none"
                        aria-label="Toggle theme"
                    >
                        <svg
                            v-if="theme === 'light'"
                            class="h-6 w-6 text-yellow-400"
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
                            class="h-6 w-6 text-yellow-400"
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
};
</script>

<style scoped>
/* Additional TailwindCSS or custom styles can be added here */
header {
    @apply sticky top-0 z-50;
}

nav a, nav button {
    @apply text-sm sm:text-base;
}

/* Smooth gradient background for header */
.bg-gradient-to-r {
    background: linear-gradient(to right, #1A1A1A, #2D2D2D);
}

/* Hover effects for buttons and links */
nav a:hover, nav button:hover {
    @apply transform scale-105;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    nav {
        @apply flex-col space-y-2;
    }
}
</style>
