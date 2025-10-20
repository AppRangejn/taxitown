<template>
    <div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-6xl mx-auto space-y-4">

            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Список замовлень</h2>
            </div>

            <div class="flex gap-2 items-center">
                <input
                    v-model="search"
                    @input="debouncedFetch"
                    placeholder="Пошук..."
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none
                           dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300"
                />
                <select v-model="sortField" @change="fetchOrders"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none
                               dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300">
                    <option value="id">ID</option>
                    <option value="from_address">Від</option>
                    <option value="to_address">До</option>
                    <option value="car_type">Авто</option>
                    <option value="price">Ціна</option>
                </select>
                <select v-model="sortOrder" @change="fetchOrders"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none
                               dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300">
                    <option value="asc">Зростання</option>
                    <option value="desc">Спадання</option>
                </select>
            </div>

            <div v-if="loading" class="text-gray-500 dark:text-gray-400">Завантаження...</div>
            <div v-if="error" class="text-red-500 dark:text-red-400">{{ error }}</div>

            <div class="overflow-x-auto">
                <table v-if="orders.length"
                       class="min-w-full bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-collapse">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Від</th>
                        <th class="px-6 py-3 text-left">До</th>
                        <th class="px-6 py-3 text-left">Авто</th>
                        <th class="px-6 py-3 text-left">Водій</th>
                        <th class="px-6 py-3 text-left">Відстань</th>
                        <th class="px-6 py-3 text-left">Ціна</th>
                        <th class="px-6 py-3 text-left">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order in orders" :key="order.id"
                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50
                               dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-3">{{ order.id }}</td>
                        <td class="px-6 py-3">{{ order.from_address }}</td>
                        <td class="px-6 py-3">{{ order.to_address }}</td>
                        <td class="px-6 py-3 capitalize">{{ order.car_type }}</td>
                        <td class="px-6 py-3">{{ order.driver?.name || '-' }}</td>
                        <td class="px-6 py-3">{{ order.distance }} км</td>
                        <td class="px-6 py-3">{{ order.price }} грн</td>
                        <td class="px-6 py-3 flex flex-col gap-2 items-end">
                            <button @click="openEdit(order)"
                                    class="px-3 py-1 bg-blue-500 dark:bg-blue-400 text-white rounded-full
                   hover:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 w-28">
                                Редагувати
                            </button>
                            <button @click="openDelete(order)"
                                    class="px-3 py-1 bg-red-500 dark:bg-red-400 text-white rounded-full
                   hover:bg-red-600 dark:hover:bg-red-500 transition-colors duration-300 w-28">
                                Видалити
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-else-if="!loading && !error"
                     class="text-gray-500 dark:text-gray-400 text-center py-4">
                    Замовлень немає
                </div>
            </div>

            <transition name="fade">
                <div v-if="showModal"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-lg">
                        <h3 class="text-xl font-bold mb-4">Редагувати замовлення</h3>
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Від</label>
                                <input v-model="form.from_address" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white
                                              focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all duration-300" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">До</label>
                                <input v-model="form.to_address" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white
                                              focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all duration-300" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Тип авто</label>
                                <select v-model="form.car_type"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white
                                               focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all duration-300">
                                    <option value="economy">Economy</option>
                                    <option value="comfort">Comfort</option>
                                    <option value="luxe">Luxe</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">ID водія</label>
                                <input v-model.number="form.driver_id" type="number"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white
                                              focus:ring-2 focus:ring-yellow-400 focus:outline-none transition-all duration-300">
                            </div>
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="closeModal"
                                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-full
                                               hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors duration-300">
                                    Скасувати
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-green-500 dark:bg-green-400 text-white rounded-full
                                               hover:bg-green-600 dark:hover:bg-green-500 transition-colors duration-300">
                                    Зберегти
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>

            <transition name="fade">
                <div v-if="showDeleteModal"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-sm shadow-lg">
                        <h3 class="text-xl font-bold mb-4">Видалити замовлення?</h3>
                        <p class="mb-4">Ви впевнені, що хочете видалити замовлення №{{ form.id }}?</p>
                        <div class="flex justify-end gap-2">
                            <button @click="closeModal"
                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-full
                                           hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors duration-300">
                                Скасувати
                            </button>
                            <button @click="deleteOrder"
                                    class="px-4 py-2 bg-red-500 dark:bg-red-400 text-white rounded-full
                                           hover:bg-red-600 dark:hover:bg-red-500 transition-colors duration-300">
                                Видалити
                            </button>
                        </div>
                    </div>
                </div>
            </transition>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

axios.defaults.baseURL = "http://localhost:8080";
axios.defaults.withCredentials = true;

const orders = ref([]);
const loading = ref(false);
const error = ref(null);

const showModal = ref(false);
const showDeleteModal = ref(false);
const form = ref({
    id: null,
    from_address: "",
    to_address: "",
    car_type: "economy",
    driver_id: null,
    distance: 0,
    price: 0,
});

const search = ref("");
const sortField = ref("id");
const sortOrder = ref("desc");

const createDebounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
};

const initCsrf = async () => {
    try {
        await axios.get("/sanctum/csrf-cookie");
    } catch (err) {
        console.warn("Не вдалося отримати CSRF cookie:", err);
    }
};

const fetchOrders = async () => {
    loading.value = true;
    error.value = null;
    try {
        await initCsrf();
        const res = await axios.get("/api/admin/orders", {
            params: { search: search.value, sortField: sortField.value, sortOrder: sortOrder.value },
        });
        orders.value = res.data.orders || (Array.isArray(res.data) ? res.data : []);
    } catch (e) {
        error.value = e.response?.data?.message || e.message;
        orders.value = [];
    } finally {
        loading.value = false;
    }
};
const debouncedFetch = createDebounce(fetchOrders);

const openEdit = (order) => {
    form.value = { ...order, driver_id: order.driver?.id || null };
    showModal.value = true;
};
const openDelete = (order) => {
    form.value = { ...order };
    showDeleteModal.value = true;
};
const closeModal = () => {
    showModal.value = false;
    showDeleteModal.value = false;
};

const submitForm = async () => {
    try {
        await initCsrf();
        await axios.put(`/api/admin/orders/${form.value.id}`, form.value);
        closeModal();
        await fetchOrders();
    } catch (e) {
        alert(e.response?.data?.message || e.message);
    }
};

const deleteOrder = async () => {
    try {
        await initCsrf();
        await axios.delete(`/api/admin/orders/${form.value.id}`);
        closeModal();
        await fetchOrders();
    } catch (e) {
        alert(e.response?.data?.message || e.message);
    }
};

onMounted(() => {
    fetchOrders();
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
