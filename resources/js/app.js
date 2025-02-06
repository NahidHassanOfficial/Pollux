import "./bootstrap";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

// Make toast globally accessible
window.toast = function (message, type = "success") {
    let bgColor = type === "success" ? "#8370f3" : "#ff4d4d";

    Toastify({
        text: message,
        duration: 1000,
        gravity: "top",
        position: "right",
        close: true,
        style: {
            background: bgColor,
            color: "#fff",
            padding: "10px 20px",
            borderRadius: "5px",
        },
    }).showToast();
};

import FingerprintJS from "@sparkstone/fingerprintjs";
window.FingerprintJS = FingerprintJS;

FingerprintJS.load().then((fp) => {
    window.fp = fp;
});
