<template>
    <div>
        <!-- Floating Admin Button -->
        <button
            v-if="!isAuthLoading && auth.user?.role === 'admin'"
            @click="isOpen = true"
            class="fixed bottom-6 right-6 z-50
           w-16 h-16
           rounded-full
           flex items-center justify-center
           bg-emerald-500 dark:bg-emerald-600
           text-white
           shadow-[0_10px_25px_rgba(0,0,0,0.4)]
           backdrop-blur-lg
           border border-white/20
           transition-all duration-300 ease-out
           hover:scale-110 hover:shadow-[0_12px_30px_rgba(16,185,129,0.6)]
           focus:outline-none"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8" fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </button>


        <!-- Modal -->
        <transition name="fade">
            <div
                v-if="isOpen"
                class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-xl flex items-center justify-center z-50 p-4 overflow-auto"
                @click.self="isOpen = false"
            >
                <div class="bg-white dark:bg-gray-800/40 rounded-2xl shadow-2xl border border-gray-200 dark:border-yellow-400/30 w-full max-w-6xl max-h-[90vh] flex flex-col overflow-hidden card-fade-in">

                    <!-- Header -->
                    <div class="px-6 py-4 border-b dark:border-gray-600 flex justify-between items-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Адмін-панель</h2>
                        <button @click="isOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Menu -->
                    <div class="flex gap-4 px-6 py-4 border-b dark:border-gray-600 overflow-x-auto">
                        <button
                            v-for="item in menuItems"
                            :key="item.id"
                            @click="selectedMenu = item.id"
                            :class="[
    'flex justify-center items-center px-6 py-3 rounded-2xl font-semibold text-sm transition-all duration-300 transform shadow-sm whitespace-nowrap',
    selectedMenu === item.id
      ? 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-black shadow-lg scale-105'
      : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white hover:scale-105 hover:shadow-md'
  ]"
                        >
                            {{ item.label }}
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 p-6 overflow-auto bg-gray-50 dark:bg-gray-900/50 transition-colors duration-300">
                        <component :is="currentComponent" />
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import useAuth from '../../composables/auth.js';
import UserManagement from './UserManagement.vue';
import DriverManagement from './DriverManagement.vue'
import AdminOrders from './AdminOrders.vue'

const { auth, getAuth } = useAuth();
const isOpen = ref(false);
const isAuthLoading = ref(true);

const menuItems = [
    { id: 'users', label: 'Користувачі', component: UserManagement },
    { id: 'drivers', label: 'Водії', component: DriverManagement },
    { id: 'orders', label: 'Замовлення', component: AdminOrders }
]
const selectedMenu = ref('users');

const currentComponent = computed(() => {
    const item = menuItems.find(i => i.id === selectedMenu.value);
    return item ? item.component : null;
});

onMounted(() => {
    getAuth().finally(() => {
        isAuthLoading.value = false;
    });
});
</script>

<style scoped>
.card-fade-in {
    animation: fadeIn 0.5s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
