<template>
    <div class="flex flex-col min-h-screen">
        <Header />

        <router-view />

        <Footer />
    </div>
</template>

<script>

import Header from './Header.vue';
import Footer from './Footer.vue';

export default {
    name: 'AppRoot',
    components: {
        Header,
        Footer,
    }
}
</script>
