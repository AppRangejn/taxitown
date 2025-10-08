<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const errors = ref({});

const deleteUser = async () => {
    if (!confirm('Ви справді хочете видалити акаунт? Це незворотньо.')) return;

    const password = prompt('Введіть пароль для підтвердження:');
    if (password === null) return;

    errors.value = {};
    try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.delete('/profile', { data: { password } });
        router.push({ name: 'home' });
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            alert('Помилка при видаленні акаунту.');
        }
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg px-6 py-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Видалити акаунт</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Усі Ваші дані буде безповоротно видалено.</p>
            <div class="space-y-4">
                <button @click="deleteUser" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Видалити акаунт</button>
                <p v-if="errors.password" class="text-sm text-red-500">{{ errors.password[0] }}</p>
            </div>
        </div>
    </div>
</template>
