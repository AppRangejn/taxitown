<script setup>
// Для цієї сторінки нам більше не потрібна складна логіка в <script>,
// оскільки навігація тепер обробляється через <router-link> у шаблоні.
</script>

<template>
    <div class="bg-white dark:bg-gray-900">
        <main class="flex-grow">
            <section class="container mx-auto px-6 py-16 md:py-24">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 text-center md:text-left">
                        <h1 class="text-4xl md:text-6xl font-bold text-gray-800 dark:text-white leading-tight">
                            Автоматизована система для вашої служби таксі
                        </h1>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                            Керуйте водіями, відстежуйте замовлення та розвивайте свій бізнес ефективніше.
                        </p>
                        <div class="mt-8 flex gap-4 justify-center md:justify-start">
                            <router-link to="/register" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                Спробувати безкоштовно
                            </router-link>
                            <router-link to="/login" class="px-8 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition-colors duration-300">
                                Увійти
                            </router-link>
                        </div>
                    </div>
                    <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center">

                    </div>
                </div>
            </section>
        </main>

        <section class="bg-gray-50 dark:bg-gray-800 py-16 md:py-24">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white">Чому обирають TaxiTown?</h2>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Все необхідне для успішної роботи в одній системі.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-700 p-8 rounded-lg shadow-lg text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 mx-auto mb-6">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Керування водіями</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Додавайте нових водіїв, відстежуйте їх статус та ефективність.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-8 rounded-lg shadow-lg text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 mx-auto mb-6">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 16.382V5.618a1 1 0 00-1.447-.894L15 7m0 10V7m0 10l-6 3"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Відстеження замовлень</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Приймайте та розподіляйте замовлення в реальному часі на інтерактивній карті.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-8 rounded-lg shadow-lg text-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 mx-auto mb-6">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Звітність та аналітика</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Аналізуйте прибутки, кількість поїздок та інші ключові показники.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-blue-600">
            <div class="container mx-auto px-6 py-16 text-center">
                <h2 class="text-4xl font-bold text-white">Готові почати?</h2>
                <p class="mt-4 text-blue-200">Створіть акаунт і почніть керувати вашою службою таксі вже сьогодні.</p>
                <div class="mt-8">
                    <router-link to="/register" class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors duration-300">
                        Зареєструватися зараз
                    </router-link>
                </div>
            </div>
        </section>
    </div>
</template>
