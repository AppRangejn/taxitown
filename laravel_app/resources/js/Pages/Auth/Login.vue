<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
    email: '',
    password: '',
    remember: false,
});
const errors = ref({});
const isProcessing = ref(false);

const submit = async () => {
    if (isProcessing.value) return;
    isProcessing.value = true;
    errors.value = {};
    try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/login', form.value);
        if (response.status === 204) {
            window.location.href = "/";
        }
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            console.error("An unexpected error occurred:", e);
        }
    } finally {
        isProcessing.value = false;
    }
};
</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">Увійдіть у свій акаунт</h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Електронна пошта</label>
                    <div class="mt-2">
                        <input v-model="form.email" id="email" type="email" required class="block w-full rounded-md border-0 py-1.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <div v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email[0] }}</div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Пароль</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="form.password" id="password" type="password" required class="block w-full rounded-md border-0 py-1.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <div v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password[0] }}</div>
                    </div>
                </div>
                <div>
                    <button
                        type="submit"
                        :disabled="isProcessing"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500"
                        :class="{'opacity-50 cursor-not-allowed': isProcessing}"
                    >
                        <span v-if="isProcessing">Вхід...</span>
                        <span v-else>Увійти</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
