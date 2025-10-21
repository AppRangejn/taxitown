<script setup>
import { ref, onMounted, watchEffect } from 'vue';
import useAuth from '@/composables/auth';
import axios from 'axios';
import { useRouter } from 'vue-router';

const { auth, getAuth } = useAuth();
const router = useRouter();

const form = ref({
    name: '',
    email: '',
});
const errors = ref({});
const status = ref('');

onMounted(getAuth);

watchEffect(() => {
    if (auth.user) {
        form.value.name = auth.user.name;
        form.value.email = auth.user.email;
    }
});

const submit = async () => {
    errors.value = {};
    status.value = '';
    try {
        await axios.patch('/profile', form.value);
        status.value = 'Успішно оновлено';
        auth.user.name = form.value.name;
        auth.user.email = form.value.email;
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};

const goBack = () => router.back();

// Тема
const theme = ref('light');
const applyTheme = () => {
    if (theme.value === 'dark') document.documentElement.classList.add('dark');
    else document.documentElement.classList.remove('dark');
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
    <div class="flex items-center justify-center min-h-screen py-12 px-4
            bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <div class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800/40
                backdrop-blur-xl shadow-lg rounded-2xl border border-gray-200 dark:border-yellow-400/30
                card-fade-in">

            <div class="text-center mb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">
                    Редагувати профіль
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Змінюйте свої особисті дані
                </p>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900 dark:text-gray-200">Ім’я</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200
                           placeholder-gray-400 dark:placeholder-gray-500 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400
                           focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                        placeholder="Ім’я"
                    />
                    <p v-if="errors.name" class="text-xs text-red-500 dark:text-red-400 mt-1 animate-pulse">{{ errors.name[0] }}</p>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-200">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200
                           placeholder-gray-400 dark:placeholder-gray-500 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400
                           focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                        placeholder="Email"
                    />
                    <p v-if="errors.email" class="text-xs text-red-500 dark:text-red-400 mt-1 animate-pulse">{{ errors.email[0] }}</p>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0 pt-2">
                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-2.5 bg-yellow-500 dark:bg-yellow-400 text-black dark:text-black
                               rounded-full hover:bg-yellow-600 dark:hover:bg-yellow-500 transition-all duration-300 font-medium">
                        Зберегти
                    </button>

                    <button type="button" @click="goBack"
                            class="w-full sm:w-auto px-6 py-2.5 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200
                               rounded-full hover:bg-gray-300 dark:hover:bg-gray-500 transition-all duration-300 font-medium">
                        Назад
                    </button>

                    <span v-if="status" class="text-sm text-green-600 dark:text-green-400 mt-2 sm:mt-0">{{ status }}</span>
                </div>
            </form>

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
.animate-pulse {
    animation: pulse 1.5s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>
