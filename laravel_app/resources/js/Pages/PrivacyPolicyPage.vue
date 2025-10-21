<template>
    <div class="relative min-h-screen bg-gradient-to-b from-black via-[#0d0d0d] to-[#1a1a1a] text-gray-200 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden z-0">
            <div v-for="n in 25" :key="n" class="particle"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 py-24 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-yellow-400 text-center mb-10 drop-shadow-[0_0_20px_rgba(255,215,0,0.4)]">
                Політика конфіденційності
            </h1>

            <p class="text-gray-400 text-center mb-16 max-w-3xl mx-auto">
                Ця політика пояснює, як <span class="text-yellow-400 font-semibold">TaxiTown</span> збирає, використовує та захищає ваші персональні дані,
                забезпечуючи максимальну прозорість і безпеку.
            </p>

            <div class="space-y-16">
                <section class="policy-section">
                    <h2 class="section-title">1. Загальні положення</h2>
                    <p>
                        Ця політика діє для всіх користувачів сервісу <span class="text-yellow-400">TaxiTown</span>
                        та визначає порядок збору, використання, зберігання і захисту персональних даних.
                        Ми дотримуємося вимог законодавства України, включно із Законом “Про захист персональних даних”.
                    </p>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">2. Збір персональних даних</h2>
                    <p>
                        Ми збираємо лише ті дані, які необхідні для якісного надання послуг:
                    </p>
                    <ul class="list-disc pl-6 mt-3 space-y-2">
                        <li>ім’я користувача, номер телефону та адресу електронної пошти;</li>
                        <li>геолокацію для точного визначення місця подачі авто;</li>
                        <li>інформацію про замовлення, історію поїздок та платежі;</li>
                        <li>IP-адресу, тип пристрою, операційну систему для аналітики.</li>
                    </ul>
                    <p class="mt-3">
                        Ми ніколи не збираємо чутливу або фінансову інформацію без вашої згоди.
                    </p>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">3. Використання даних</h2>
                    <p>
                        Отримані дані використовуються виключно для:
                    </p>
                    <ul class="list-disc pl-6 mt-3 space-y-2">
                        <li>обробки замовлень і забезпечення зручності користування сервісом;</li>
                        <li>зв’язку з користувачем у разі змін або проблем із поїздкою;</li>
                        <li>покращення якості обслуговування, аналітики та розробки нових функцій;</li>
                        <li>забезпечення безпеки користувачів та запобігання шахрайству.</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">4. Зберігання та захист інформації</h2>
                    <p>
                        Ми зберігаємо ваші дані на захищених серверах із використанням сучасних технологій шифрування.
                        Доступ до персональної інформації мають лише уповноважені співробітники,
                        які зобов’язані зберігати конфіденційність.
                    </p>
                    <p class="mt-3">
                        TaxiTown застосовує SSL-з’єднання, двофакторну автентифікацію та регулярні перевірки безпеки систем.
                    </p>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">5. Передача даних третім сторонам</h2>
                    <p>
                        Ми не передаємо ваші персональні дані третім особам,
                        окрім випадків, коли це необхідно для надання послуг (наприклад, водіям)
                        або вимагається законом.
                    </p>
                    <p class="mt-3">
                        Усі партнери TaxiTown підписують угоду про конфіденційність (NDA)
                        та відповідають вимогам GDPR і локальних законів.
                    </p>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">6. Ваші права</h2>
                    <p>
                        Кожен користувач має право:
                    </p>
                    <ul class="list-disc pl-6 mt-3 space-y-2">
                        <li>отримувати інформацію про свої персональні дані;</li>
                        <li>вимагати виправлення або видалення неточних даних;</li>
                        <li>відкликати згоду на обробку даних у будь-який момент;</li>
                        <li>подати скаргу до відповідних органів у разі порушення прав.</li>
                    </ul>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">7. Файли Cookie</h2>
                    <p>
                        Наш сайт використовує файли cookie для забезпечення стабільної роботи,
                        запам’ятовування налаштувань користувача та аналітики трафіку.
                        Ви можете вимкнути cookie у налаштуваннях браузера,
                        але це може обмежити функціонал сервісу.
                    </p>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">8. Зміни в політиці</h2>
                    <p>
                        Ми залишаємо за собою право вносити зміни до цієї політики конфіденційності.
                        Актуальна версія завжди доступна на нашому сайті.
                        У разі суттєвих змін ми повідомимо користувачів електронною поштою або в додатку.
                    </p>
                </section>

                <section class="policy-section">
                    <h2 class="section-title">9. Контактна інформація</h2>
                    <p>
                        Якщо у вас виникли запитання щодо цієї політики, звертайтесь:
                    </p>
                    <div class="mt-3 space-y-1">
                        <p><strong>Email:</strong> <a href="mailto:support@taxitown.com" class="text-yellow-400 hover:underline">support@taxitown.com</a></p>
                        <p><strong>Телефон:</strong> <a href="tel:+380931234567" class="text-yellow-400 hover:underline">+380 (93) 123-45-67</a></p>
                        <p><strong>Адреса:</strong> м. Житомир, вул. Київська, 77</p>
                    </div>
                </section>
            </div>

            <div class="text-center mt-16">
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
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
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

.policy-section {
    @apply bg-[#111] p-8 rounded-2xl border border-yellow-400/10 shadow-[0_0_20px_rgba(255,215,0,0.05)] hover:shadow-[0_0_30px_rgba(255,215,0,0.2)] transition-all duration-500;
}
.section-title {
    @apply text-2xl font-bold text-yellow-400 mb-4 tracking-wide;
}
.policy-section p {
    @apply text-gray-400 leading-relaxed;
}
.policy-section ul li {
    @apply text-gray-300;
}
</style>
