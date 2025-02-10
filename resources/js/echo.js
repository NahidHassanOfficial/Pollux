import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

import { getAuthToken } from "/public/js/auth";
const auth_token = getAuthToken();
window.getAuthToken = getAuthToken;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],

    authEndpoint: "/api/broadcasting/auth",
    auth: {
        headers: {
            Authorization: "Bearer " + auth_token,
        },
    },
});
