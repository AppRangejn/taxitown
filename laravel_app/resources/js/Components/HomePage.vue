<template>
    <div
        class="relative min-h-screen overflow-hidden transition-colors duration-300"
        :class="theme === 'dark' ? 'bg-gray-900 text-white' : 'bg-gray-50 text-gray-900'"
    >
        <!-- 🗺️ Карта -->
        <div id="map" class="absolute inset-0 w-full h-full z-0 transition-all duration-700"></div>

        <!-- 🌫️ Димка при звичайному режимі -->
        <div
            v-if="mapMode === 'normal'"
            class="absolute inset-0 z-10 backdrop-blur-md"
            :class="theme === 'dark' ? 'bg-black/30' : 'bg-white/30'"
        ></div>

        <!-- 📋 Мої замовлення -->
        <transition name="slide-in-left">
            <div
                v-if="orders.length"
                class="absolute top-2 left-8 z-20 w-[420px] rounded-2xl shadow-2xl backdrop-blur-xl p-5 border transition-all duration-700"
                :class="theme === 'dark' ? 'bg-gray-800/90 border-gray-700' : 'bg-white/90 border-gray-200'"
            >
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-bold text-yellow-400">📋 Мої замовлення</h2>
                    <button
                        @click="reloadOrders"
                        class="text-xs px-3 py-1 rounded-full border transition"
                        :class="theme==='dark' ? 'border-gray-600 hover:bg-gray-700' : 'border-gray-300 hover:bg-gray-100'"
                    >
                        🔄 Оновити
                    </button>
                </div>

                <div v-if="loadingOrders" class="text-gray-400">Завантаження...</div>

                <div v-else class="space-y-3 max-h-[400px] overflow-y-auto pr-2">
                    <div
                        v-for="o in orders"
                        :key="o.id"
                        class="p-3 rounded-lg border shadow-inner transition-all duration-300"
                        :class="theme==='dark'
          ? 'bg-gray-700/50 border-gray-700 hover:bg-gray-700/80'
          : 'bg-gray-100 border-gray-200 hover:bg-gray-200/80'"
                    >
                        <div class="flex items-start justify-between gap-3">
                            <div class="text-sm">
                                <p><b>🚕 Від:</b> {{ o.from_address }}</p>
                                <p><b>🎯 До:</b> {{ o.to_address }}</p>
                                <p><b>💰</b> {{ o.price }} грн — {{ o.distance }} км</p>
                            </div>
                        </div>

                        <div class="mt-2 flex items-center justify-between">
                            <p class="text-xs text-yellow-500">⏱️ Активне замовлення</p>
                            <button
                                @click="cancelOrder(o.id)"
                                class="text-xs px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-full transition"
                            >
                                ❌ Відмінити
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>


        <!-- 💳 Головна форма -->
        <div
            class="z-20 rounded-2xl shadow-2xl backdrop-blur-xl p-6 w-[420px] border transition-all duration-700"
            :class="[theme==='dark' ? 'bg-gray-800/90 border-gray-700' : 'bg-white/90 border-gray-200',
        formDocked ? 'fixed right-8 top-20' : 'absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2']"
        >
            <!-- Етапи -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2 text-xs">
          <span class="px-2 py-1 rounded-full"
                :class="stage>=1 ? 'bg-yellow-400 text-black' : 'bg-gray-300 dark:bg-gray-700 dark:text-gray-300'">1</span>
                    <div class="w-8 h-0.5"
                         :class="stage>=2 ? 'bg-yellow-400' : theme==='dark' ? 'bg-gray-700' : 'bg-gray-300'"></div>
                    <span class="px-2 py-1 rounded-full"
                          :class="stage>=2 ? 'bg-yellow-400 text-black' : 'bg-gray-300 dark:bg-gray-700 dark:text-gray-300'">2</span>
                    <div class="w-8 h-0.5"
                         :class="stage>=3 ? 'bg-yellow-400' : theme==='dark' ? 'bg-gray-700' : 'bg-gray-300'"></div>
                    <span class="px-2 py-1 rounded-full"
                          :class="stage>=3 ? 'bg-yellow-400 text-black' : 'bg-gray-300 dark:bg-gray-700 dark:text-gray-300'">3</span>
                </div>
            </div>

            <!-- 🔹 Етап 1 -->
            <transition name="fade">
                <div v-if="stage === 1" class="space-y-3">
                    <h2 class="text-2xl font-bold mb-1">🚖 Замовлення поїздки</h2>
                    <input v-model="order.from" placeholder="Звідки"
                           class="w-full p-3 rounded-lg border bg-transparent outline-none focus:ring-2 focus:ring-yellow-400"
                           :class="theme === 'dark' ? 'border-gray-700' : 'border-gray-300'"/>
                    <input v-model="order.to" placeholder="Куди"
                           class="w-full p-3 rounded-lg border bg-transparent outline-none focus:ring-2 focus:ring-yellow-400"
                           :class="theme === 'dark' ? 'border-gray-700' : 'border-gray-300'"/>

                    <div class="flex gap-2">
                        <button v-if="mapMode==='normal'" @click="enterRouteMode"
                                class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded-lg transition">
                            📍 Побудувати маршрут
                        </button>
                        <button v-if="mapMode==='route'" @click="buildRoute"
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg transition">
                            🚖 Побудувати
                        </button>
                    </div>

                    <button :disabled="!canGoNextFromStage1" @click="goStage(2)"
                            class="w-full mt-2 py-2 rounded-lg font-semibold transition"
                            :class="canGoNextFromStage1
                    ? 'bg-yellow-400 hover:bg-yellow-500 text-black'
                    : theme==='dark' ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'">
                        Далі
                    </button>
                </div>
            </transition>

            <!-- 🔹 Етап 2 -->
            <transition name="fade">
                <div v-if="stage === 2" class="space-y-3">
                    <h2 class="text-2xl font-bold">🚗 Обери клас та водія</h2>

                    <div class="flex justify-center gap-2">
                        <button
                            v-for="type in ['economy','comfort','luxe']"
                            :key="type"
                            @click="order.carType = type"
                            class="px-3 py-1 rounded-full text-sm font-bold uppercase transition"
                            :class="order.carType===type
                ? 'bg-yellow-400 text-black'
                : theme==='dark' ? 'bg-gray-700 text-gray-200 hover:bg-gray-600' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'">
                            {{ type }}
                        </button>
                    </div>

                    <div v-if="loadingDrivers" class="text-gray-400">Завантаження водіїв…</div>
                    <div v-else-if="driverError" class="text-red-400">{{ driverError }}</div>
                    <div v-else-if="drivers[order.carType]?.length" class="grid grid-cols-1 gap-2 max-h-44 overflow-y-auto">
                        <div v-for="d in drivers[order.carType]" :key="d.id" @click="order.driver = d"
                             class="flex items-center gap-3 p-3 rounded-lg cursor-pointer transition border"
                             :class="order.driver?.id===d.id
                    ? 'border-2 border-yellow-400 ' + (theme==='dark'?'bg-yellow-400/10':'bg-yellow-100/60')
                    : theme==='dark' ? 'border-gray-700 hover:bg-gray-800' : 'border-gray-200 hover:bg-gray-100'">
                            <img :src="d.photo || '/images/default.jpg'" class="w-10 h-10 rounded-full object-cover"/>
                            <div>
                                <p class="font-semibold">{{ d.name }}</p>
                                <p class="text-xs opacity-70">{{ d.phone || '—' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button @click="goStage(1)"
                                class="flex-1 py-2 rounded-lg font-semibold transition"
                                :class="theme==='dark' ? 'bg-gray-700 hover:bg-gray-600' : 'bg-gray-200 hover:bg-gray-300'">
                            Назад
                        </button>
                        <button :disabled="!order.driver" @click="goStage(3)"
                                class="flex-1 py-2 rounded-lg font-semibold transition"
                                :class="order.driver
                      ? 'bg-yellow-400 hover:bg-yellow-500 text-black'
                      : theme==='dark' ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'">
                            Далі
                        </button>
                    </div>
                </div>
            </transition>

            <!-- 🔹 Етап 3 -->
            <transition name="fade">
                <div v-if="stage === 3" class="space-y-3">
                    <h2 class="text-2xl font-bold">✅ Перевір дані</h2>
                    <div class="text-sm space-y-1">
                        <p>📍 <b>Від:</b> {{ order.from }}</p>
                        <p>🏁 <b>До:</b> {{ order.to }}</p>
                        <p>📏 <b>Відстань:</b> {{ order.distance }} км</p>
                        <p>🕒 <b>Час:</b> ~{{ travelTime }} хв</p>
                        <p>🚗 <b>Клас:</b> {{ order.carType }}</p>
                        <p>👨‍✈️ <b>Водій:</b> {{ order.driver?.name || '—' }}</p>
                        <p class="text-2xl font-extrabold text-yellow-400 mt-2">💰 {{ order.price.toFixed(0) }} грн</p>
                    </div>

                    <div class="flex gap-2">
                        <button @click="goStage(2)"
                                class="flex-1 py-2 rounded-lg font-semibold transition"
                                :class="theme==='dark' ? 'bg-gray-700 hover:bg-gray-600' : 'bg-gray-200 hover:bg-gray-300'">
                            Назад
                        </button>
                        <button @click="submitOrder"
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold transition">
                            🚀 Замовити
                        </button>
                    </div>
                </div>
            </transition>
        </div>

        <!-- 🧭 Нижня панель -->
        <transition name="fade-up">
            <div
                v-if="mapMode!=='normal'"
                class="absolute bottom-20 left-1/2 -translate-x-1/2 w-[92%] max-w-3xl rounded-2xl border shadow-2xl px-5 py-4 z-30 backdrop-blur-xl"
                :class="theme==='dark' ? 'bg-black/75 border-gray-700 text-white' : 'bg-white/80 border-gray-200 text-gray-900'"
            >
                <div class="flex flex-col md:flex-row items-center justify-between gap-3">
                    <div class="text-sm md:text-base space-y-1 w-full">
                        <p>📍 <b>Від:</b> {{ order.from || '—' }}</p>
                        <p>🏁 <b>До:</b> {{ order.to || '—' }}</p>
                        <div class="flex gap-6">
                            <p>📏 <b>Відстань:</b> {{ order.distance ? order.distance + ' км' : '—' }}</p>
                            <p>🕒 <b>Час:</b> {{ travelTime ? '~' + travelTime + ' хв' : '—' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <p class="text-2xl font-extrabold text-yellow-500">
                            💰 {{ order.price ? order.price.toFixed(0) : '—' }} грн
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>


<script setup>
import { ref, reactive, computed, onMounted, onBeforeUnmount, watch } from 'vue';
import axios from 'axios';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// ===== ТЕМА
const theme = ref(localStorage.getItem('theme') || 'light');
const applyTheme = () => {
    if (theme.value === 'dark') document.documentElement.classList.add('dark');
    else document.documentElement.classList.remove('dark');
};
const onStorage = (e) => {
    if (e.key === 'theme') {
        theme.value = e.newValue || 'light';
        applyTheme();
    }
};
onMounted(() => {
    applyTheme();
    window.addEventListener('storage', onStorage);
});
onBeforeUnmount(() => window.removeEventListener('storage', onStorage));

// 🔥 миттєва реакція
watch(theme, (val) => {
    localStorage.setItem('theme', val);
    applyTheme();
});

// ===== AXIOS
axios.defaults.baseURL = 'http://localhost:8080';
axios.defaults.withCredentials = true;

// ===== СТАН
const mapMode = ref('normal');
const controlEnabled = ref(false);
const formDocked = computed(() => mapMode.value !== 'normal');
const stage = ref(1);
const order = reactive({
    from: '',
    to: '',
    carType: 'economy',
    distance: 0,
    price: 0,
    driver: null
});
const travelTime = ref(0);
const canGoNextFromStage1 = computed(() => !!(order.from && order.to && order.distance));

// ===== ВОДІЇ
const drivers = reactive({ economy: [], comfort: [], luxe: [] });
const loadingDrivers = ref(false);
const driverError = ref(null);

// ===== ЗАМОВЛЕННЯ
const orders = ref([]);
const loadingOrders = ref(false);
let tick = null;

// ===== КАРТА
let map, fromMarker, toMarker, routeLayer;

onMounted(async () => {
    initMap();
    await Promise.all([loadDrivers(), loadOrders()]);
    startTimers();
});
onBeforeUnmount(() => { if (tick) clearInterval(tick); });

function initMap() {
    map = L.map('map', { zoomControl: true }).setView([50.45, 30.52], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    map.on('click', async (e) => {
        if (mapMode.value !== 'route') return;
        if (!fromMarker) {
            fromMarker = L.marker(e.latlng).addTo(map).bindPopup('Старт').openPopup();
            order.from = await reverseGeocode(e.latlng);
        } else if (!toMarker) {
            toMarker = L.marker(e.latlng).addTo(map).bindPopup('Фініш').openPopup();
            order.to = await reverseGeocode(e.latlng);
        }
    });
}

// ===== РЕВЕРС ГЕО
async function reverseGeocode({ lat, lng }) {
    try {
        const res = await fetch(
            `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=uk`
        );
        const data = await res.json();
        return data.display_name || `(${lat.toFixed(3)}, ${lng.toFixed(3)})`;
    } catch {
        return `(${lat.toFixed(3)}, ${lng.toFixed(3)})`;
    }
}

// ===== ЦІНА У РЕАЛЬНОМУ ЧАСІ
watch(
    () => [order.carType, order.driver, order.distance],
    () => {
        if (!order.distance) return;
        const base = { economy: 50, comfort: 80, luxe: 150 };
        const perKm = { economy: 10, comfort: 18, luxe: 30 };
        order.price = base[order.carType] + perKm[order.carType] * order.distance;
    },
    { deep: true }
);

// ===== ROUTE
async function buildRoute() {
    if (!fromMarker || !toMarker) return alert('Вкажи дві точки');
    const from = fromMarker.getLatLng();
    const to = toMarker.getLatLng();

    const res = await fetch(
        `https://router.project-osrm.org/route/v1/driving/${from.lng},${from.lat};${to.lng},${to.lat}?overview=full&geometries=geojson`
    );
    const data = await res.json();
    const route = data.routes?.[0];
    if (!route) return alert('Не вдалося побудувати маршрут');

    if (routeLayer) routeLayer.remove();
    const coords = route.geometry.coordinates.map((c) => [c[1], c[0]]);
    routeLayer = L.polyline(coords, { color: '#FFD800', weight: 5 }).addTo(map);
    map.fitBounds(routeLayer.getBounds(), { padding: [50, 50] });

    order.distance = (route.distance / 1000).toFixed(1);
    travelTime.value = Math.round(route.duration / 60);
    mapMode.value = 'built';
}

// ===== ВОДІЇ
async function loadDrivers() {
    loadingDrivers.value = true;
    try {
        const res = await axios.get('/api/drivers');
        const list = Array.isArray(res.data) ? res.data : res.data.drivers || [];
        const bucket = { economy: [], comfort: [], luxe: [] };
        list.forEach((d) => {
            const t = d.car_type || 'economy';
            bucket[t].push(d);
        });
        Object.assign(drivers, bucket);
    } catch (e) {
        driverError.value = e.message;
    } finally {
        loadingDrivers.value = false;
    }
}

// ===== ORDERS
async function loadOrders() {
    loadingOrders.value = true;
    try {
        const res = await axios.get('/api/orders');
        orders.value = res.data?.orders || [];
    } finally {
        loadingOrders.value = false;
    }
}


async function reloadOrders() {
    await loadOrders();
}

function startTimers() {
    tick = setInterval(() => {
        orders.value.forEach((o) => {
            if (o.remaining > 0) o.remaining--;
        });
    }, 1000);
}

async function cancelOrder(id) {
    if (!confirm('Ви впевнені, що хочете скасувати це замовлення?')) return;
    try {
        // 👉 Спочатку отримуємо CSRF cookie
        await axios.get('/sanctum/csrf-cookie');

        // Потім видаляємо
        await axios.delete(`/api/orders/${id}`);
        orders.value = orders.value.filter((o) => o.id !== id);
        alert('✅ Замовлення скасовано!');
    } catch (e) {
        console.error(e);
        alert('❌ Не вдалося скасувати замовлення: ' + (e.response?.data?.message || e.message));
    }
}

onMounted(() => loadOrders());
// ===== ORDER SUBMIT
async function submitOrder() {
    try {
        if (!order.from || !order.to || !order.driver) return alert('Заповни всі поля');
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/api/orders', {
            from_address: order.from,
            to_address: order.to,
            car_type: order.carType,
            driver_id: order.driver.id,
            distance: order.distance,
            price: order.price
        });
        alert('✅ Замовлення створено!');
        await loadOrders();
        clearRoute();
    } catch (e) {
        alert('Помилка: ' + e.message);
    }
}

// ===== ДОДАТКОВІ
function enterRouteMode() {
    mapMode.value = 'route';
}

function goStage(n) {
    stage.value = n;
}

function clearRoute() {
    [fromMarker, toMarker, routeLayer].forEach((m) => m && map.removeLayer(m));
    fromMarker = toMarker = routeLayer = null;
    order.from = '';
    order.to = '';
    order.distance = 0;
    order.price = 0;
    order.driver = null;
    stage.value = 1;
    mapMode.value = 'normal';
}
</script>


<style scoped>
/* === Анімації появи === */

/* 🔸 Зліва (панель замовлень) */
.slide-in-left-enter-active {
    transition: all 0.5s ease;
}
.slide-in-left-enter-from {
    transform: translateX(-100%);
    opacity: 0;
}

/* 🔸 Fade (плавна поява/зникнення контенту) */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* 🔸 Fade-up (знизу вверх для нижньої панелі) */
.fade-up-enter-active,
.fade-up-leave-active {
    transition: all 0.4s ease;
}
.fade-up-enter-from {
    opacity: 0;
    transform: translateY(24px);
}
.fade-up-leave-to {
    opacity: 0;
    transform: translateY(24px);
}

/* === Кастомізація скролу (для списку замовлень) === */
::-webkit-scrollbar {
    width: 8px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background-color: rgba(160, 160, 160, 0.4);
    border-radius: 8px;
}
.dark ::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.25);
}

/* === Адаптивна поведінка === */
@media (max-width: 768px) {
    .w-\[420px\] {
        width: 90%;
    }

    .absolute.left-8 {
        left: 4%;
    }

    .fixed.right-8.top-20 {
        right: 4%;
        top: 1.5rem;
    }
}

/* === Анімація зміни теми (м’який перехід між темною/світлою) === */
:root,
html,
body {
    transition: background-color 0.4s ease, color 0.4s ease;
}

</style>
