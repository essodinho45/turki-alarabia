import './bootstrap';

import moment from 'moment';
console.log(moment().format());

import Pikaday from 'pikaday';
import 'pikaday/css/pikaday.css';

import app from "@/utils/initialize";
import { getMessaging, getToken, onMessage, deleteToken } from "https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging.js";

window.Pikaday = Pikaday;

const messaging = getMessaging(app);

function requestPermission() {
    console.log("Requesting permission...");
    Notification.requestPermission().then((permission) => {
        if (permission === "granted") {
            console.log("Notification permission granted.");
        }
    });
}

window.setToken = function () {
    getToken(messaging, {
        vapidKey: import.meta.env.VITE_VAPID_KEY,
    })
        .then((currentToken) => {
            if (currentToken) {
                // Send the token to your server and update the UI if necessary

                var data = new FormData();
                data.append("_token", document.querySelector('meta[name="csrf-token"]').content);
                navigator.sendBeacon(
                    `/setToken?fcm_token=${currentToken}`
                    , data
                ); //ping the server with the new device token
            } else {
                // Show permission request UI
                console.log(
                    "No registration token available. Request permission to generate one."
                );
                requestPermission();
                // ...
            }
        })
        .catch((err) => {
            console.log("An error occurred while retrieving token. ", err);
            // ...
        });
}

onMessage(messaging, function ({ notification }) {
    new Notification(notification.title, {
        body: notification.body,
    });
    // ...
});
