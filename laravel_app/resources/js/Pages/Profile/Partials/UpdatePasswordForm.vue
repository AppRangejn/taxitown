<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = ref({
    current_password: '',
    password: '',
    password_confirmation: '',
});
const errors = ref({});
const status = ref('');

// Збереження пароля
const submit = async () => {
    errors.value = {};
    status.value = '';
    try {
        await axios.put('/password', form.value);
        status.value = 'Пароль успішно оновлено.';
        form.value.current_password = '';
        form.value.password = '';
        form.value.password_confirmation = '';
    } catch (e) {
        if (e.response && e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};

// Повернутись назад
const goBack = () => router.back();
</script>

<template>
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

        <!-- Основний контент -->
        <main class="flex-grow flex justify-center items-center px-4">
            <div class="w-full max-w-md p-6 sm:p-8 bg-white dark:bg-gray-800/40
                  backdrop-blur-xl shadow-lg rounded-2xl border border-gray-200 dark:border-yellow-400/30
                  card-fade-in">

                <div class="text-center mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">
                        Змінити пароль
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Введіть поточний та новий пароль
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Поточний пароль
                        </label>
                        <input id="current_password" v-model="form.current_password" type="password"
                               class="mt-1 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600
                          bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200
                          placeholder-gray-400 dark:placeholder-gray-500 rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400
                          focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                               placeholder="Поточний пароль"/>
                        <p v-if="errors.current_password" class="text-xs text-red-500 dark:text-red-400 mt-1 animate-pulse">{{ errors.current_password[0] }}</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Новий пароль
                        </label>
                        <input id="password" v-model="form.password" type="password"
                               class="mt-1 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600
                          bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200
                          placeholder-gray-400 dark:placeholder-gray-500 rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400
                          focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                               placeholder="Новий пароль"/>
                        <p v-if="errors.password" class="text-xs text-red-500 dark:text-red-400 mt-1 animate-pulse">{{ errors.password[0] }}</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Підтвердити пароль
                        </label>
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password"
                               class="mt-1 block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600
                          bg-white dark:bg-gray-900/50 text-gray-900 dark:text-gray-200
                          placeholder-gray-400 dark:placeholder-gray-500 rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-400
                          focus:border-yellow-500 dark:focus:border-yellow-400 sm:text-sm transition-all duration-300 hover:bg-gray-50 dark:hover:bg-gray-800/70"
                               placeholder="Підтвердити пароль"/>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0 pt-2">
                        <button type="submit"
                                class="w-full sm:w-auto px-6 py-2.5 bg-yellow-500 dark:bg-yellow-400 text-black dark:text-black
                           rounded-full hover:bg-yellow-600 dark:hover:bg-yellow-500 transition-all duration-300 font-medium">
                            Оновити пароль
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
        </main>

        <!-- Footer -->
        <Footer />
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
