<script setup>
import { computed, onMounted } from 'vue';
import useAuth from '@/composables/auth';
import { useRouter } from 'vue-router';

const { auth, getAuth } = useAuth();
const router = useRouter();

onMounted(getAuth);

const registrationDate = computed(() => {
    if (!auth.user || !auth.user.created_at) return '';
    return new Date(auth.user.created_at).toLocaleDateString('uk-UA', {
        year: 'numeric', month: 'long', day: 'numeric'
    });
});

// Функції для навігації залишаються, але ми їх поки не використовуємо,
// оскільки сторінки редагування ще не створені.
const goToEdit = () => router.push({ name: 'profile.edit' });
const goToPassword = () => router.push({ name: 'profile.password' });
const goToDelete = () => router.push({ name: 'profile.delete' });
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div v-if="auth.user" class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-8 text-center border-b border-gray-200 dark:border-gray-700">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ auth.user.name }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Зареєстрований: {{ registrationDate }}</p>
                </div>

                <div class="px-6 py-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Особисті дані</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Користувача:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ auth.user.id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Електронна пошта:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ auth.user.email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Роль:</span>
                            <span class="text-sm text-gray-900 dark:text-white capitalize">{{ auth.user.role }}</span>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Налаштування акаунту</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" @click="goToEdit">
                            <span class="text-gray-800 dark:text-gray-200">Редагувати профіль</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors" @click="goToPassword">
                            <span class="text-gray-800 dark:text-gray-200">Змінити пароль</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-red-500/10 dark:hover:bg-red-500/20 transition-colors" @click="goToDelete">
                            <span class="text-red-600 dark:text-red-400">Видалити акаунт</span>
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div v-else class="text-center text-gray-600 dark:text-gray-400">
            Завантаження даних профілю...
        </div>
    </div>
</template>
