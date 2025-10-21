<template>
    <div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-6xl mx-auto space-y-4">

            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Список водіїв</h2>
                <button @click="openAdd"
                        class="px-4 py-2 bg-green-500 dark:bg-green-400 text-white rounded-full hover:bg-green-600 dark:hover:bg-green-500 transition-colors duration-300 font-medium">
                    Додати водія
                </button>
            </div>

            <div class="flex gap-2 items-center">
                <input v-model="search" @input="fetchDrivers" placeholder="Пошук..."
                       class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300"/>
                <select v-model="sortField" @change="fetchDrivers"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300">
                    <option value="id">ID</option>
                    <option value="name">Ім'я</option>
                    <option value="phone">Телефон</option>
                    <option value="status">Статус</option>
                    <option value="car_type">Тип авто</option>
                </select>
                <select v-model="sortOrder" @change="fetchDrivers"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300">
                    <option value="asc">Зростання</option>
                    <option value="desc">Спадання</option>
                </select>
            </div>

            <div v-if="loading" class="text-gray-500 dark:text-gray-400">Завантаження...</div>
            <div v-if="error" class="text-red-500 dark:text-red-400">{{ error }}</div>

            <div class="overflow-x-auto">
                <table v-if="drivers.length" class="min-w-full bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-collapse">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Ім'я</th>
                        <th class="px-6 py-3 text-left">Телефон</th>
                        <th class="px-6 py-3 text-left">Досвід (роки)</th>
                        <th class="px-6 py-3 text-left">Фото</th>
                        <th class="px-6 py-3 text-left">Статус</th>
                        <th class="px-6 py-3 text-left">Тип авто</th>
                        <th class="px-6 py-3 text-left">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="driver in drivers" :key="driver.id"
                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-3">{{ driver.id }}</td>
                        <td class="px-6 py-3">{{ driver.name }}</td>
                        <td class="px-6 py-3">{{ driver.phone }}</td>
                        <td class="px-6 py-3">{{ driver.experience_years }}</td>
                        <td class="px-6 py-3">
                            <img v-if="driver.photo" :src="driver.photo" alt="Фото" class="w-12 h-12 rounded-full object-cover"/>
                        </td>
                        <td class="px-6 py-3 capitalize">{{ driver.status }}</td>
                        <td class="px-6 py-3">{{ driver.car_type }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <button @click="openEdit(driver)"
                                    class="px-3 py-1 bg-blue-500 dark:bg-blue-400 text-white rounded-full hover:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300">
                                Редагувати
                            </button>
                            <button @click="openDelete(driver)"
                                    class="px-3 py-1 bg-red-500 dark:bg-red-400 text-white rounded-full hover:bg-red-600 dark:hover:bg-red-500 transition-colors duration-300">
                                Видалити
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-else-if="!loading && !error" class="text-gray-500 dark:text-gray-400 text-center py-4">
                    Водіїв немає
                </div>
            </div>

            <transition name="fade">
                <div v-if="showModal"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.self="closeModal" class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-lg">
                        <h3 class="text-xl font-bold mb-4">{{ modalMode === 'add' ? 'Додати водія' : 'Редагувати водія' }}</h3>
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Ім'я</label>
                                <input v-model="form.name" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                       required/>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Телефон</label>
                                <input v-model="form.phone" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                       required/>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Досвід (роки)</label>
                                <input v-model="form.experience_years" type="number" min="0"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"/>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Фото (URL)</label>
                                <input v-model="form.photo" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"/>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Статус</label>
                                <select v-model="form.status"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300">
                                    <option value="free">Вільний</option>
                                    <option value="busy">Зайнятий</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Тип авто</label>
                                <input v-model="form.car_type" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"/>
                            </div>
                            <div class="flex justify-end gap-2 mt-4">
                                <button type="button" @click="closeModal"
                                        class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors duration-300">
                                    Скасувати
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-green-500 dark:bg-green-400 text-white rounded-full hover:bg-green-600 dark:hover:bg-green-500 transition-colors duration-300">
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
                        <h3 class="text-xl font-bold mb-4">Видалити водія?</h3>
                        <p class="mb-4">Ви впевнені, що хочете видалити {{ form.name }}?</p>
                        <div class="flex justify-end gap-2">
                            <button @click="closeModal"
                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors duration-300">
                                Скасувати
                            </button>
                            <button @click="deleteDriver"
                                    class="px-4 py-2 bg-red-500 dark:bg-red-400 text-white rounded-full hover:bg-red-600 dark:hover:bg-red-500 transition-colors duration-300">
                                Видалити
                            </button>
                        </div>
                    </div>
                </div>
            </transition>

        </div>
    </div>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8080'
axios.defaults.withCredentials = true

const drivers = ref([])
const loading = ref(false)
const error = ref(null)

const showModal = ref(false)
const showDeleteModal = ref(false)
const modalMode = ref('add')
const form = ref({ id: null, name: '', phone: '', experience_years: 0, photo: '', status: 'free', car_type: '' })

const search = ref('')
const sortField = ref('id')
const sortOrder = ref('desc')

const driversCount = computed(() => drivers.value.length)

const initCsrf = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie')
    } catch (err) {
        console.warn('Не вдалося отримати CSRF cookie:', err)
    }
}

const fetchDrivers = async () => {
    loading.value = true
    error.value = null
    try {
        const res = await axios.get('/api/drivers', {
            params: {
                search: search.value,
                sortField: sortField.value,
                sortOrder: sortOrder.value
            }
        })

        if (Array.isArray(res.data)) {
            drivers.value = res.data
        } else if (res.data.drivers) {
            drivers.value = res.data.drivers
        } else {
            drivers.value = []
        }

    } catch (e) {
        error.value = e.response?.data?.message || e.message
        drivers.value = []
    } finally {
        loading.value = false
    }
}

const openAdd = () => {
    modalMode.value = 'add'
    form.value = { id: null, name: '', phone: '', experience_years: 0, photo: '', status: 'free', car_type: '' }
    showModal.value = true
}
const openEdit = (driver) => {
    modalMode.value = 'edit'
    form.value = { ...driver }
    showModal.value = true
}
const openDelete = (driver) => {
    form.value = { ...driver }
    showDeleteModal.value = true
}
const closeModal = () => {
    showModal.value = false
    showDeleteModal.value = false
}

const submitForm = async () => {
    try {
        await initCsrf()
        if (modalMode.value === 'add') {
            await axios.post('/api/drivers', form.value)
        } else {
            await axios.put(`/api/drivers/${form.value.id}`, form.value)
        }
        closeModal()
        fetchDrivers()
    } catch (e) {
        alert(e.response?.data?.message || e.message)
    }
}

const deleteDriver = async () => {
    try {
        await initCsrf()
        await axios.delete(`/api/drivers/${form.value.id}`)
        closeModal()
        fetchDrivers()
    } catch (e) {
        alert(e.response?.data?.message || e.message)
    }
}

fetchDrivers()
</script>

