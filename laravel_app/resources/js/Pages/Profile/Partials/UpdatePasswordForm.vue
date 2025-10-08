<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
    current_password: '',
    password: '',
    password_confirmation: '',
});
const errors = ref({});
const status = ref('');

const submit = async () => {
    errors.value = {};
    status.value = '';
    try {
        const resp = await axios.put('/password', form.value);
        status.value = 'Пароль оновлено';
        form.value.current_password = '';
        form.value.password = '';
        form.value.password_confirmation = '';
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg px-6 py-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Змінити пароль</h2>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm text-gray-700 dark:text-gray-300">Поточний пароль</label>
                    <input id="current_password" v-model="form.current_password" type="password"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-yellow-500 focus:ring-yellow-500"/>
                    <p v-if="errors.current_password" class="text-sm text-red-500 mt-1">{{ errors.current_password[0] }}</p>
                </div>
                <div>
                    <label for="password" class="block text-sm text-gray-700 dark:text-gray-300">Новий пароль</label>
                    <input id="password" v-model="form.password" type="password"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-yellow-500 focus:ring-yellow-500"/>
                    <p v-if="errors.password" class="text-sm text-red-500 mt-1">{{ errors.password[0] }}</p>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm text-gray-700 dark:text-gray-300">Підтвердити пароль</label>
                    <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-yellow-500 focus:ring-yellow-500"/>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">Оновити пароль</button>
                    <span v-if="status" class="text-sm text-green-600">{{ status }}</span>
                </div>
            </form>
        </div>
    </div>
</template>
