<template>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
        <h1 class="text-5xl font-bold text-blue-600 mb-6">Ласкаво просимо до TaxiTown!</h1>
        <p class="text-gray-700 text-lg">Система керування користувачами та замовленнями.</p>
        <div class="mt-6 flex gap-4">
            <button class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" @click="goToLogin">
                Увійти
            </button>
            <button class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600" @click="goToRegister">
                Реєстрація
            </button>

        </div>
    </div>
</template>

<script>
export default {
    name: 'AppRoot',
    methods: {
        goToLogin() {
            window.location.href = '/login';
        },
        goToRegister() {
            window.location.href = '/register';
        }
    }
}
</script>

<style scoped>
/* додаткові стилі, якщо потрібно */
</style>
