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


app.config.globalProperties.$swal = Swal;


window.alert = (message) => {
    Alert.info("Повідомлення", message);
};


app.config.globalProperties.$alert = Alert;
