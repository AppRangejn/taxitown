<template>
    <div class="flex flex-col min-h-screen">
        <Header />
        <main class="flex-grow">
            <router-view />
        </main>
        <Footer />

        <AdminPanel v-if="!isAuthLoading && auth.user?.role === 'admin'" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Header from './Header.vue';
import Footer from './Footer.vue';
import AdminPanel from './admin/AdminPanel.vue';
import useAuth from '../composables/auth.js';

const { auth, getAuth } = useAuth();
const isAuthLoading = ref(true);

onMounted(async () => {
    await getAuth();
    isAuthLoading.value = false;
});
</script>
