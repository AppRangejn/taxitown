<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { RouterLink, useRouter } from 'vue-router';

const form = ref({
    email: '',
    password: '',
    remember: false,
});
const errors = ref({});
const isProcessing = ref(false);
const theme = ref('light');
const router = useRouter();

const applyTheme = () => {
    if (theme.value === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

onMounted(() => {

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        theme.value = savedTheme;
    }
    applyTheme();
});

const submit = async () => {
    isProcessing.value = true;
    errors.value = {};

    try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/login', form.value);

        if (response.status === 204) {

            await router.push('/');
        }
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            console.error('Unexpected error:', e);
        }
    } finally {
        isProcessing.value = false;
    }
}



</script>

<template>
    <div class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gradient-to-br dark:from-gray-900 dark:to-black transition-colors duration-300">
        <div class="w-full max-w-sm sm:max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800/40 backdrop-blur-xl shadow-lg rounded-2xl border border-gray-200 dark:border-yellow-400/30">

            <div class="text-center">
                <img src="/taxi-icon.png" alt="TaxiTown Logo" class="mx-auto h-12 w-auto" />
                <h2 class="mt-4 text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Увійдіть у свій акаунт
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Немає акаунта?
                    <RouterLink to="/register" class="font-medium text-yellow-500 dark:text-yellow-400 hover:text-yellow-600 dark:hover:text-yellow-300 transition-colors duration-300">
                        Зареєструйтесь
                    </RouterLink>
                </p>
            </div>


            <form @submit.prevent="submit" class="mt-6 space-y-4">
                <div class="space-y-3">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-200">Електронна пошта</label>
                        <div class="mt-1">
                            <input
                                v-model="form.email"
                                id="email"
                                type="email"
                                required
                                class="appearance-none relative block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                                placeholder="Електронна пошта"
                            />
                            <div v-if="errors.email" class="text-red-500 dark:text-red-400 text-xs mt-1 animate-pulse">{{ errors.email[0] }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-200">Пароль</label>
                        </div>
                        <div class="mt-1">
                            <input
                                v-model="form.password"
                                id="password"
                                type="password"
                                required
                                class="appearance-none relative block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                                placeholder="Пароль"
                            />
                            <div v-if="errors.password" class="text-red-500 dark:text-red-400 text-xs mt-1 animate-pulse">{{ errors.password[0] }}</div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input
                            v-model="form.remember"
                            id="remember"
                            type="checkbox"
                            class="h-4 w-4 text-yellow-500 dark:text-yellow-400 focus:ring-yellow-500 dark:focus:ring-yellow-400 border-gray-300 dark:border-gray-600 rounded"
                        />
                        <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-200">
                            Запам’ятати мене
                        </label>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="isProcessing"
                        class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-full text-black bg-yellow-500 dark:bg-yellow-400 hover:bg-yellow-600 dark:hover:bg-yellow-500 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-yellow-400 focus:ring-offset-white dark:focus:ring-offset-gray-900 transition-all duration-300"
                        :class="{ 'opacity-50 cursor-not-allowed': isProcessing }"
                    >
                        <span v-if="isProcessing" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Вхід...
                        </span>
                        <span v-else>Увійти</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.animate-pulse {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

button:hover {
    @apply shadow-lg shadow-yellow-500/20;
}

input {
    @apply shadow-sm;
}

.max-w-sm {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
    .max-w-sm {
        @apply w-full px-4;
    }
}
</style>
