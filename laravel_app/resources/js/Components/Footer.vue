<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';

const theme = ref('light');
const showScrollTop = ref(false);

const applyTheme = () => {
    if (theme.value === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        theme.value = savedTheme;
    }
    applyTheme();

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
        class="w-full bg-[#1A1A1A] text-gray-300 border-t border-gray-800 shadow-inner"
    >
        <div class="container mx-auto px-4 sm:px-6 py-3">
            <div
                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 text-sm"
            >
                <!-- Логотип -->
                <div class="flex items-center space-x-2">
                    <img src="/taxi-icon.png" alt="TaxiTown Logo" class="h-8 w-8" />
                    <span class="text-lg font-semibold text-yellow-400 tracking-tight">
                        TaxiTown
                    </span>
                </div>

                <!-- Посилання -->
                <div class="flex space-x-6">
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

                <!-- Соцмережі -->
                <div class="flex space-x-4">
                    <a
                        href="https://t.me/taxitown"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-yellow-400 transition-all duration-300 hover:scale-110"
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
                        class="hover:text-yellow-400 transition-all duration-300 hover:scale-110"
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

            <div class="mt-3 text-center text-xs text-gray-500">
                © 2025 TaxiTown. Всі права захищено.
            </div>
        </div>

        <!-- Кнопка "Вгору" -->
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

/* Трохи нижчий футер */
footer .container {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
}

/* Адаптивність */
@media (max-width: 640px) {
    footer .container {
        @apply py-3 px-4;
    }
    footer img {
        @apply h-7 w-7;
    }
    footer a, footer span {
        @apply text-xs;
    }
    .fixed {
        bottom: 1rem;
        right: 1rem;
        padding: 0.5rem;
    }
}
</style>
