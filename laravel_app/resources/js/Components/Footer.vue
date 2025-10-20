<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';

const showScrollTop = ref(false);

onMounted(() => {
    window.addEventListener('scroll', () => {
        showScrollTop.value = window.scrollY > 100;
    });
});

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <footer
        class="w-full bg-gradient-to-r from-[#0d0d0d] via-[#1a1a1a] to-black text-gray-300 border-t border-yellow-400/20 shadow-[0_-4px_20px_rgba(255,215,0,0.05)]"
    >
        <div class="container mx-auto px-6 py-6">
            <div
                class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 text-sm"
            >
                <!-- 🚕 Лого -->
                <div class="flex items-center space-x-3">
                    <img
                        src="/taxi-icon.png"
                        alt="TaxiTown Logo"
                        class="h-10 w-10 drop-shadow-[0_0_10px_rgba(255,215,0,0.4)]"
                    />
                    <span
                        class="text-xl font-extrabold text-yellow-400 tracking-tight hover:text-yellow-300 transition-all duration-300"
                    >
                        TaxiTown
                    </span>
                </div>

                <!-- 🔗 Посилання -->
                <div class="flex space-x-8 text-gray-400 font-medium">
                    <RouterLink
                        to="/contacts"
                        class="hover:text-yellow-400 transition-all duration-300 hover:scale-105"
                    >
                        Контакти
                    </RouterLink>
                    <RouterLink
                        to="/privacy"
                        class="hover:text-yellow-400 transition-all duration-300 hover:scale-105"
                    >
                        Політика конфіденційності
                    </RouterLink>
                </div>

                <!-- 🌐 Соцмережі -->
                <div class="flex space-x-4">
                    <a
                        href="https://t.me/taxitown"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="p-2 rounded-full bg-gray-800 text-yellow-400 hover:bg-yellow-400 hover:text-black transition-all duration-300 shadow-md hover:shadow-yellow-400/30 hover:scale-110"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.76.22-1.3l16.38-6.26a.8.8 0 01.99.95l-1.78 15.59a.8.8 0 01-.95.7l-4.96-.95-4.96-.95z"
                            />
                        </svg>
                    </a>
                    <a
                        href="https://instagram.com/taxitown"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="p-2 rounded-full bg-gray-800 text-yellow-400 hover:bg-yellow-400 hover:text-black transition-all duration-300 shadow-md hover:shadow-yellow-400/30 hover:scale-110"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"
                            />
                            <circle cx="12" cy="12" r="3.5" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 📝 Підпис -->
            <div
                class="mt-5 text-center text-xs text-gray-500 border-t border-gray-800 pt-3"
            >
                © 2025
                <span class="text-yellow-400 font-semibold">TaxiTown</span>. Усі права
                захищено.
            </div>
        </div>

        <!-- 🔝 Кнопка "Вгору" -->
        <button
            v-show="showScrollTop"
            @click="scrollToTop"
            class="fixed bottom-6 right-6 z-50 p-3 rounded-full bg-yellow-400 text-black shadow-lg hover:bg-yellow-500 transition-all duration-300 hover:scale-110 focus:outline-none"
            aria-label="Повернутися вгору"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 10l7-7m0 0l7 7m-7-7v18"
                />
            </svg>
        </button>
    </footer>
</template>

<style scoped>
footer {
    animation: fadeIn 0.4s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* 📱 Адаптивність */
@media (max-width: 640px) {
    footer .container {
        @apply py-3 px-4;
    }
    footer img {
        @apply h-7 w-7;
    }
    footer a,
    footer span {
        @apply text-xs;
    }
    .fixed {
        bottom: 1rem;
        right: 1rem;
        padding: 0.5rem;
    }
}
</style>
