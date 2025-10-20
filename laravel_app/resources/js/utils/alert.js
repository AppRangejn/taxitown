import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import { useToast } from "vue-toastification";

/**
 * Alert Utility (TaxiTown Edition)
 * Комбінує SweetAlert2 + Vue Toastification
 * Використовується для повідомлень, помилок, підтверджень, тостів
 */

/**
 * 🌓 Автоматичне визначення теми (світла/темна)
 */
function getThemeColors() {
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    if (prefersDark || document.documentElement.classList.contains("dark")) {
        // Темна тема
        return {
            background: "#1f2937", // gray-800
            color: "#f9fafb", // text-gray-100
            confirmButtonColor: "#10b981", // emerald-500
            cancelButtonColor: "#6b7280", // gray-500
            borderColor: "#374151", // gray-700
        };
    } else {
        // Світла тема
        return {
            background: "#f9fafb", // gray-50
            color: "#1f2937", // gray-800
            confirmButtonColor: "#10b981", // emerald-500
            cancelButtonColor: "#9ca3af", // gray-400
            borderColor: "#d1d5db", // gray-300
        };
    }
}

/**
 * 🔧 Генерація базових налаштувань SweetAlert2 з урахуванням теми
 */
function getBaseConfig() {
    const theme = getThemeColors();
    return {
        background: theme.background,
        color: theme.color,
        confirmButtonColor: theme.confirmButtonColor,
        cancelButtonColor: theme.cancelButtonColor,
        customClass: {
            popup: `rounded-2xl shadow-2xl backdrop-blur-md border border-[${theme.borderColor}]`,
            confirmButton: "px-4 py-2 rounded-lg font-semibold",
            cancelButton: "px-4 py-2 rounded-lg font-semibold",
        },
    };
}

/**
 * 🌟 Основний об’єкт Alert
 */
const Alert = {
    // === TOAST (Toastification) ===
    toast(message = "Повідомлення", type = "info", timeout = 3000) {
        const toast = useToast();
        switch (type) {
            case "success":
                toast.success(message, { timeout });
                break;
            case "error":
                toast.error(message, { timeout });
                break;
            case "warning":
                toast.warning(message, { timeout });
                break;
            case "info":
            default:
                toast.info(message, { timeout });
        }
    },

    // === МОДАЛКИ SweetAlert2 ===
    success(title = "Успішно!", text = "", timer = 2000) {
        return Swal.fire({
            ...getBaseConfig(),
            icon: "success",
            title,
            text,
            timer,
            showConfirmButton: false,
        });
    },

    error(title = "Помилка!", text = "Щось пішло не так 😢") {
        return Swal.fire({
            ...getBaseConfig(),
            icon: "error",
            title,
            text,
        });
    },

    info(title = "Інформація", text = "") {
        return Swal.fire({
            ...getBaseConfig(),
            icon: "info",
            title,
            text,
        });
    },

    warning(title = "Увага!", text = "") {
        return Swal.fire({
            ...getBaseConfig(),
            icon: "warning",
            title,
            text,
        });
    },

    async confirm(
        title = "Підтвердження",
        text = "Ви впевнені?",
        confirmText = "Так",
        cancelText = "Скасувати"
    ) {
        return Swal.fire({
            ...getBaseConfig(),
            title,
            text,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
        });
    },
};

/**
 * 🌍 Глобальні заміни window.alert і window.confirm
 * (щоб навіть старий код автоматично використовував гарні вікна)
 */
window.alert = (message) => {
    Alert.info("Повідомлення", message);
};

window.confirm = async (message) => {
    const result = await Alert.confirm("Підтвердження", message);
    return result.isConfirmed; // true / false
};

export default Alert;
