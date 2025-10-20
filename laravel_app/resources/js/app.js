import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import router from './router';
import AppRoot from './Components/AppRoot.vue';

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import Alert from "@/utils/alert.js";

const app = createApp(AppRoot);

app.use(router);

app.mount('#app');

app.use(Toast, {
    position: "top-right",
    timeout: 3000,
    closeOnClick: true,
    pauseOnHover: true,
});

// Робимо SweetAlert доступним глобально
app.config.globalProperties.$swal = Swal;

// 🔧 Замінюємо стандартний alert()
window.alert = (message) => {
    Alert.info("Повідомлення", message);
};

// Експортуємо Alert для використання у будь-якому місці
app.config.globalProperties.$alert = Alert;
