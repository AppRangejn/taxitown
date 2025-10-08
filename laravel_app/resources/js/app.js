import '../css/app.css';
import './bootstrap';
import { createApp } from 'vue';
import AppRoot from './Components/AppRoot.vue';

const app = createApp(AppRoot);
app.mount('#app');
