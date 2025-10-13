<template>
    <div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-6xl mx-auto space-y-4">

            <!-- Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Список користувачів</h2>
                <button @click="openAdd"
                        class="px-4 py-2 bg-green-500 dark:bg-green-400 text-white rounded-full hover:bg-green-600 dark:hover:bg-green-500 transition-colors duration-300 font-medium">
                    Додати користувача
                </button>
            </div>

            <!-- Search & Sort -->
            <div class="flex gap-2 items-center">
                <input v-model="search" @input="fetchUsers" placeholder="Пошук..."
                       class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 focus:outline-none dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300"/>
                <select v-model="sortField" @change="fetchUsers"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300">
                    <option value="id">ID</option>
                    <option value="name">Ім'я</option>
                    <option value="email">Email</option>
                    <option value="role">Роль</option>
                </select>
                <select v-model="sortOrder" @change="fetchUsers"
                        class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400 dark:bg-gray-800 dark:text-white dark:border-gray-700 transition-all duration-300">
                    <option value="asc">Зростання</option>
                    <option value="desc">Спадання</option>
                </select>
            </div>

            <!-- Loading/Error -->
            <div v-if="loading" class="text-gray-500 dark:text-gray-400">Завантаження...</div>
            <div v-if="error" class="text-red-500 dark:text-red-400">{{ error }}</div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table v-if="users.length" class="min-w-full bg-white dark:bg-gray-800 rounded-2xl shadow-lg border-collapse">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm">
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Ім'я</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Роль</th>
                        <th class="px-6 py-3 text-left">Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id"
                        class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-3">{{ user.id }}</td>
                        <td class="px-6 py-3">{{ user.name }}</td>
                        <td class="px-6 py-3">{{ user.email }}</td>
                        <td class="px-6 py-3 capitalize">{{ user.role }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <button @click="openEdit(user)"
                                    class="px-3 py-1 bg-blue-500 dark:bg-blue-400 text-white rounded-full hover:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300">
                                Редагувати
                            </button>
                            <button @click="openDelete(user)"
                                    class="px-3 py-1 bg-red-500 dark:bg-red-400 text-white rounded-full hover:bg-red-600 dark:hover:bg-red-500 transition-colors duration-300">
                                Видалити
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-else-if="!loading && !error" class="text-gray-500 dark:text-gray-400 text-center py-4">
                    Користувачів немає
                </div>
            </div>

            <!-- Modal Add/Edit -->
            <transition name="fade">
                <div v-if="showModal"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.self="closeModal" class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-lg">
                        <h3 class="text-xl font-bold mb-4">{{ modalMode === 'add' ? 'Додати користувача' : 'Редагувати користувача' }}</h3>
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Ім'я</label>
                                <input v-model="form.name" type="text"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                       required/>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Email</label>
                                <input v-model="form.email" type="email"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                       required/>
                            </div>
                            <div>
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Роль</label>
                                <select v-model="form.role"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300">
                                    <option value="user">Користувач</option>
                                    <option value="admin">Адмін</option>
                                </select>
                            </div>
                            <div v-if="modalMode === 'add'">
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Пароль</label>
                                <input v-model="form.password" type="password"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                       required/>
                            </div>
                            <div v-if="modalMode === 'edit'">
                                <label class="block mb-1 text-gray-700 dark:text-gray-200">Новий пароль (залишіть порожнім, щоб не змінювати)</label>
                                <input v-model="form.password" type="password"
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

            <!-- Modal Delete -->
            <transition name="fade">
                <div v-if="showDeleteModal"
                     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-sm shadow-lg">
                        <h3 class="text-xl font-bold mb-4">Видалити користувача?</h3>
                        <p class="mb-4">Ви впевнені, що хочете видалити {{ form.name }}?</p>
                        <div class="flex justify-end gap-2">
                            <button @click="closeModal"
                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors duration-300">
                                Скасувати
                            </button>
                            <button @click="deleteUser"
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
import { ref } from 'vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://localhost:8080'
axios.defaults.withCredentials = true

const users = ref([])
const loading = ref(false)
const error = ref(null)

const showModal = ref(false)
const showDeleteModal = ref(false)
const modalMode = ref('add')
const form = ref({ id: null, name: '', email: '', role: 'user', password: '' })

// --- CSRF ---
const initCsrf = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie')
    } catch (err) {
        console.warn('Не вдалося отримати CSRF cookie:', err)
    }
}

const search = ref('')
const sortField = ref('id')
const sortOrder = ref('desc')
// --- Fetch Users ---
const fetchUsers = async () => {
    loading.value = true
    error.value = null
    try {
        const res = await axios.get('/api/users', {
            params: {
                search: search.value,
                sortField: sortField.value,
                sortOrder: sortOrder.value
            }
        })
        users.value = res.data
    } catch (e) {
        error.value = e.response?.data?.message || e.message
        users.value = []
    } finally {
        loading.value = false
    }
}

// --- Modals ---
const openAdd = () => {
    modalMode.value = 'add'
    form.value = { id: null, name: '', email: '', role: 'user', password: '' }
    showModal.value = true
}
const openEdit = (user) => {
    modalMode.value = 'edit'
    form.value = { ...user, password: '' }
    showModal.value = true
}
const openDelete = (user) => {
    form.value = { ...user }
    showDeleteModal.value = true
}
const closeModal = () => {
    showModal.value = false
    showDeleteModal.value = false
}

// --- Submit (Add/Edit) ---
const submitForm = async () => {
    try {
        await initCsrf()
        if (modalMode.value === 'add') {
            await axios.post('/api/users', form.value)
        } else {
            await axios.post(`/api/users/${form.value.id}`, form.value)
        }
        closeModal()
        fetchUsers()
    } catch (e) {
        if (e.response && e.response.status === 422) {
            const errors = e.response.data.errors
            let errorMessage = "Помилка валідації:\n"
            for (const key in errors) {
                errorMessage += `- ${errors[key][0]}\n`
            }
            alert(errorMessage)
        } else {
            alert(e.response?.data?.message || e.message)
        }
    }
}

// --- Delete ---
const deleteUser = async () => {
    try {
        await initCsrf()
        await axios.post(`/api/users/${form.value.id}/delete`)
        closeModal()
        fetchUsers()
    } catch (e) {
        alert(e.response?.data?.message || e.message)
    }
}

// --- On Mounted ---
fetchUsers()
</script>
