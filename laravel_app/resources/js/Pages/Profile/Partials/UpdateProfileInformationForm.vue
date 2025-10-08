<script setup>
import { ref, onMounted } from 'vue';
import useAuth from '@/composables/auth';
import axios from 'axios';

const { auth, getAuth } = useAuth();
onMounted(getAuth);

const form = ref({
    name: '',
    email: '',
});
const errors = ref({});
const status = ref('');

onMounted(() => {
    if (auth.user) {
        form.value.name = auth.user.name;
        form.value.email = auth.user.email;
    }
});

const submit = async () => {
    errors.value = {};
    status.value = '';
    try {
        const resp = await axios.patch('/profile', form.value);
        status.value = 'Успішно оновлено';
        // оновити auth.user
        auth.user.name = form.value.name;
        auth.user.email = form.value.email;
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
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Редагувати профіль</h2>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm text-gray-700 dark:text-gray-300">Ім’я</label>
                    <input id="name" v-model="form.name" type="text"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-yellow-500 focus:ring-yellow-500"/>
                    <p v-if="errors.name" class="text-sm text-red-500 mt-1">{{ errors.name[0] }}</p>
                </div>
                <div>
                    <label for="email" class="block text-sm text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" v-model="form.email" type="email"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-yellow-500 focus:ring-yellow-500"/>
                    <p v-if="errors.email" class="text-sm text-red-500 mt-1">{{ errors.email[0] }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">Зберегти</button>
                    <span v-if="status" class="text-sm text-green-600">{{ status }}</span>
                </div>
            </form>
        </div>
    </div>
</template>
