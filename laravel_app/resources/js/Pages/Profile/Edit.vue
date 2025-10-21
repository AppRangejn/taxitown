<script setup>
import { ref, computed, onMounted } from 'vue';
import useAuth from '@/composables/auth';
import { useRouter } from 'vue-router';

const { auth, getAuth } = useAuth();
const router = useRouter();

onMounted(getAuth);

const registrationDate = computed(() => {
    if (!auth.user || !auth.user.created_at) return '';
    return new Date(auth.user.created_at).toLocaleDateString('uk-UA', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
});

const goBack = () => router.back();
const goToEdit = () => router.push({ name: 'profile.edit' });
const goToPassword = () => router.push({ name: 'profile.password' });
const goToDelete = () => router.push({ name: 'profile.delete' });

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
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) theme.value = savedTheme;
    applyTheme();
});
</script>

<template>
    <div class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8
            bg-white dark:bg-gray-900 transition-colors duration-300">
        <div v-if="auth.user" class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800/40
                backdrop-blur-xl shadow-lg rounded-2xl border border-gray-200 dark:border-yellow-400/30
                card-fade-in">


            <div @click="goBack"
                 class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-6 cursor-pointer transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Назад</span>
            </div>

            <div class="text-center mb-6">
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
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ auth.user.name }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Зареєстрований: {{ registrationDate }}
                </p>
            </div>

            <div class="space-y-3 mb-6">
                <div class="flex justify-between px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400">ID Користувача:</span>
                    <span class="text-gray-900 dark:text-white">{{ auth.user.id }}</span>
                </div>
                <div class="flex justify-between px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400">Електронна пошта:</span>
                    <span class="text-gray-900 dark:text-white">{{ auth.user.email }}</span>
                </div>
                <div class="flex justify-between px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <span class="text-gray-500 dark:text-gray-400">Роль:</span>
                    <span class="text-gray-900 dark:text-white capitalize">{{ auth.user.role }}</span>
                </div>
            </div>

            <div class="space-y-4">
                <button @click="goToEdit"
                        class="w-full py-2.5 px-4 bg-yellow-500 dark:bg-yellow-400 text-black dark:text-black
                       rounded-full hover:bg-yellow-600 dark:hover:bg-yellow-500 transition-all duration-300 font-medium">
                    Редагувати профіль
                </button>
                <button @click="goToPassword"
                        class="w-full py-2.5 px-4 bg-yellow-500 dark:bg-yellow-400 text-black dark:text-black
                       rounded-full hover:bg-yellow-600 dark:hover:bg-yellow-500 transition-all duration-300 font-medium">
                    Змінити пароль
                </button>
                <button @click="goToDelete"
                        class="w-full py-2.5 px-4 bg-red-600 dark:bg-red-500 text-white
                       rounded-full hover:bg-red-700 dark:hover:bg-red-600 transition-all duration-300 font-medium">
                    Видалити акаунт
                </button>
            </div>

        </div>

        <div v-else class="text-center text-gray-600 dark:text-gray-400">
            Завантаження даних профілю...
        </div>
    </div>
</template>

<style scoped>
.card-fade-in {
    animation: fadeIn 0.5s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
