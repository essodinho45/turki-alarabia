import './bootstrap';

import moment from 'moment';

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
    deleteToken(messaging);
    getToken(messaging, {
        vapidKey: import.meta.env.VITE_VAPID_KEY,
    })
        .then((currentToken) => {
            console.log(currentToken);
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
    document.querySelectorAll("body").forEach(body => body.style.display = "block");
}

onMessage(messaging, function ({ notification }) {
    console.log(notification);
    new Notification(notification.title, {
        body: notification.body,
    });
    // ...
});

self.addEventListener("push", (event) => {
    console.log(event);
    // let response = event.data && event.data.text();
    // let title = JSON.parse(response).notification.title;
    // let body = JSON.parse(response).notification.body;
    //
    // event.waitUntil(
    //     self.registration.showNotification(title, { body, icon, image, data: { url: JSON.parse(response).data.url } })
    // )
});
