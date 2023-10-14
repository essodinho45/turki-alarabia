importScripts(
    "https://www.gstatic.com/firebasejs/10.5.0/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/10.5.0/firebase-messaging-compat.js"
);

firebase.initializeApp({
    apiKey: "AIzaSyCSouWPGPBvmw5kgfgyYyQbg6n44oJbAyc",
    authDomain: "turki-alarabia.firebaseapp.com",
    projectId: "turki-alarabia",
    storageBucket: "turki-alarabia.appspot.com",
    messagingSenderId: "570609799086",
    appId: "1:570609799086:web:6f46a2d17ea79c903f023f",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(({ notification }) => {
    console.log("[firebase-messaging-sw.js] Received background message ");
    // Customize notification here
    const notificationTitle = notification.title;
    const notificationOptions = {
        body: notification.body,
    };

    if (notification.icon) {
        notificationOptions.icon = notification.icon;
    }

    self.registration.showNotification(notificationTitle, notificationOptions);
});
