// FCM 
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js";
  import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-messaging.js";

  const firebaseConfig = {
      apiKey: "AIzaSyCAH-0xJGwcrXJwklXPqg5U_pXa0hFXBLA",
      authDomain: "mbilling-772a2.firebaseapp.com",
      projectId: "mbilling-772a2",
      storageBucket: "mbilling-772a2.appspot.com",
      messagingSenderId: "677549830511",
      appId: "1:677549830511:web:f5b6c423006cdad02f389a",
      measurementId: "G-P02787XXTQ"
  };

  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
  let messaging;
  try {
    messaging = getMessaging(app);
  } catch (error) {
    // alert('Terjadi kesalahan: ' + error.message);
    // alert('Notifikasi FireBase Tidak Suport');
  }

  async function initFirebaseMessagingRegistration() {
    try {
      const permission = await Notification.requestPermission();
      if (permission !== 'granted') {
        alert('Permission denied by user');
        return;
      }
      const token = await getToken(messaging);
      await axios.post(URLupdateDevice, {
          token
      }, {
        headers: {
          'X-CSRF-TOKEN': csrf_token
        }
      });
    } catch (error) {
      alert(`Token Error :: ${error}`);
    }
  }


  initFirebaseMessagingRegistration();

  onMessage(messaging, (payload) => {
      const { body, title } = payload.notification;
      new Notification(title, { body });
  });

  if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
          navigator.serviceWorker.register(firebaseSwJs)
              .then((registration) => {
                  // console.log('Service Worker registered:', registration);
              })
              .catch((error) => {
                  // console.error('Service Worker registration failed:', error);
              });
      });
  }


