importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyCSouWPGPBvmw5kgfgyYyQbg6n44oJbAyc",
    projectId: "turki-alarabia",
    messagingSenderId: "570609799086",
    appId: "1:570609799086:web:6f46a2d17ea79c903f023f",

});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function ({ data: { title, body, icon } }) {
    return self.registration.showNotification(title, { body, icon });
});
