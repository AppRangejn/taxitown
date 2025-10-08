<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <h1 class="text-4xl font-bold text-blue-600 mb-6">Ласкаво просимо до TaxiTown!</h1>
    <p class="text-gray-700 text-lg">Тут ти можеш керувати користувачами, замовленнями та бачити статистику.</p>
    <button class="mt-6 px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" @click="goToDashboard">
      Перейти до панелі
    </button>
  </div>
</template>

<script>
export default {
  name: 'WelcomeComponent',
  methods: {
    goToDashboard() {
      window.location.href = '/dashboard';
    }
  }
}
</script>

<style scoped>
/* Локальні стилі, якщо потрібно */
</style>
