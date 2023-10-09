importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
firebase.initializeApp({
    apiKey: "AIzaSyCAH-0xJGwcrXJwklXPqg5U_pXa0hFXBLA",
    projectId: "mbilling-772a2",
    messagingSenderId: "677549830511",
    appId: "1:677549830511:web:f5b6c423006cdad02f389a",
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});