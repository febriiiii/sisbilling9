var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
//   '/',
//   '/css/app.css',
//   '/js/app.js',
//   '/images/icon.png'
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function(cache) {
            return cache.addAll(urlsToCache.map(url => new Request(url, { credentials: 'same-origin' })));
        })
    );
});
self.addEventListener('fetch', function(event) {
    if (event.request.method === 'GET') {
      event.respondWith(
        caches.match(event.request)
          .then(function(response) {
            if (response) {
              return response;
            }
  
            var fetchRequest = event.request.clone();
  
            return fetch(fetchRequest).then(
              function(response) {
                if (!response || response.status !== 200 || response.type !== 'basic') {
                  return response;
                }
  
                var responseToCache = response.clone();
  
                caches.open(CACHE_NAME)
                  .then(function(cache) {
                    cache.put(event.request, responseToCache);
                  });
  
                return response;
              }
            );
          })
      );
    } else {
      // Jika permintaan bukan GET, biarkan langsung mengambil dari jaringan
      event.respondWith(fetch(event.request));
    }
  });
  
