<template>
    <div class="relative min-h-screen bg-gradient-to-b from-black via-[#0d0d0d] to-[#1a1a1a] text-gray-200 overflow-hidden">

        <div class="absolute inset-0 overflow-hidden z-0">
            <div v-for="n in 20" :key="n" class="particle"></div>
        </div>


        <div class="relative z-10 flex flex-col items-center justify-center py-24 px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-400 mb-4 animate-fade-in-down">
                Зв’яжіться з <span class="text-yellow-300 drop-shadow-[0_0_20px_rgba(255,215,0,0.5)]">TaxiTown</span>
            </h1>

            <p class="max-w-2xl text-gray-400 mb-12 animate-fade-in-up">
                Ми завжди поруч, щоб допомогти вам! Залиште повідомлення, або знайдіть нас у соцмережах.
            </p>


            <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 max-w-4xl w-full animate-fade-in-up delay-200">
                <div class="contact-card">
                    <div class="icon-wrap bg-yellow-400/10">
                        <svg class="icon" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2A19.73 19.73 0 0 1 3.11 4.18 2 2 0 0 1 5.11 2h3a2 2 0 0 1 2 1.72c.09.66.26 1.31.5 1.93a2 2 0 0 1-.45 2.11l-1.27 1.27a16 16 0 0 0 7.27 7.27l1.27-1.27a2 2 0 0 1 2.11-.45c.62.24 1.27.41 1.93.5A2 2 0 0 1 22 16.92z"
                            />
                        </svg>
                    </div>
                    <p class="text-yellow-400 font-semibold">Телефон</p>
                    <a href="tel:+380931234567" class="text-gray-300 hover:text-yellow-300 transition">+380 (93) 123-45-67</a>
                </div>

                <div class="contact-card">
                    <div class="icon-wrap bg-yellow-400/10">
                        <svg class="icon" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"
                            />
                        </svg>
                    </div>
                    <p class="text-yellow-400 font-semibold">Email</p>
                    <a href="mailto:support@taxitown.com" class="text-gray-300 hover:text-yellow-300 transition">support@taxitown.com</a>
                </div>

                <div class="contact-card">
                    <div class="icon-wrap bg-yellow-400/10">
                        <svg class="icon" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.633 7.997c.014.2.014.4.014.6 0 6.1-4.646 13.13-13.13 13.13A13.07 13.07 0 0 1 0 19.124a9.54 9.54 0 0 0 1.12.064 9.3 9.3 0 0 0 5.77-1.98 4.64 4.64 0 0 1-4.33-3.21c.28.042.55.07.84.07.4 0 .79-.056 1.16-.15a4.63 4.63 0 0 1-3.71-4.54v-.06a4.7 4.7 0 0 0 2.09.58A4.62 4.62 0 0 1 .94 4.38a13.15 13.15 0 0 0 9.55 4.84 5.23 5.23 0 0 1-.11-1.06 4.63 4.63 0 0 1 8.01-3.17 9.09 9.09 0 0 0 2.94-1.12 4.6 4.6 0 0 1-2.03 2.55 9.3 9.3 0 0 0 2.66-.72 9.9 9.9 0 0 1-2.4 2.27z"
                            />
                        </svg>
                    </div>
                    <p class="text-yellow-400 font-semibold">Telegram</p>
                    <a href="https://t.me/taxitown" target="_blank" class="text-gray-300 hover:text-yellow-300 transition">@taxitown</a>
                </div>
            </div>

            <div class="mt-16 w-full max-w-4xl">
                <iframe
                    class="rounded-2xl shadow-[0_0_25px_rgba(255,215,0,0.2)] w-full h-80"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2538.9935487787824!2d28.6767!3d50.25465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x472c651c97d8169d%3A0x62e28efaf93269c0!2sZhytomyr%20Polytechnic%20State%20University!5e0!3m2!1sen!2sua!4v1700000000000"
                    allowfullscreen=""
                    loading="lazy"
                ></iframe>
            </div>

            <div class="mt-10">
                <RouterLink to="/" class="text-yellow-400 hover:text-yellow-300 transition">
                    ← Повернутись на головну
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fadeInDown {
    0% {
        opacity: 0;
        transform: translateY(-30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}
.animate-fade-in-down {
    animation: fadeInDown 0.8s ease-out forwards;
}

.delay-200 {
    animation-delay: 0.2s;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 215, 0, 0.3);
    border-radius: 50%;
    animation: float 12s linear infinite;
}
@keyframes float {
    0% {
        transform: translateY(0) translateX(0);
        opacity: 0.6;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) translateX(20vw);
        opacity: 0;
    }
}
.particle:nth-child(odd) {
    animation-duration: 10s;
    background: rgba(255, 215, 0, 0.4);
}
.particle:nth-child(even) {
    animation-duration: 14s;
}

.contact-card {
    @apply flex flex-col items-center justify-center p-6 bg-[#111] rounded-2xl border border-yellow-400/10 shadow-[0_0_15px_rgba(255,215,0,0.05)] hover:shadow-[0_0_25px_rgba(255,215,0,0.2)] hover:scale-105 transition-all duration-300;
}
.icon-wrap {
    @apply p-4 rounded-full mb-3 text-yellow-400;
}
.icon {
    @apply h-8 w-8;
}
</style>
