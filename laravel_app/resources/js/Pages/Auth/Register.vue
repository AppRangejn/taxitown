<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});
const errors = ref({});
const isProcessing = ref(false);

const submit = async () => {
    if (isProcessing.value) return;

    isProcessing.value = true;
    errors.value = {};
    try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/register', form.value);
        window.location.href = "/";
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    } finally {
        isProcessing.value = false;
    }
};
</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">Створити акаунт</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <button
                        type="submit"
                        :disabled="isProcessing"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :class="{'opacity-50 cursor-not-allowed': isProcessing}"
                    >
                        <span v-if="isProcessing">Реєстрація...</span>
                        <span v-else>Зареєструватися</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
