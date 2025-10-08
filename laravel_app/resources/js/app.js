import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import router from './router';
import AppRoot from './Components/AppRoot.vue'; // <-- Ось виправлення

const app = createApp(AppRoot);

app.use(router);

app.mount('#app');
