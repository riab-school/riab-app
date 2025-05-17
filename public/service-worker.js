const staticCacheName = 'precache-v3.0.1';
const dynamicCacheName = 'runtimecache-v3.0.1';

// Pre Caching Assets
const precacheAssets = [
    'mobile-assets/img/core-img/logo-small.png',
    'mobile-assets/img/core-img/logo-white.png',
    'mobile-assets/img/bg-img/no-internet.png',
    'mobile-assets/js/theme-switching.js',
    'assets/images/logo.png',
    'assets/images/logo-dark.png',
    'assets/images/logo-white.png',
    'assets/images/favicon.ico',
];

// Install Event
self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(staticCacheName).then(function (cache) {
            return cache.addAll(precacheAssets);
        })
    );
});

// Activate Event
self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
                .filter(key => key !== staticCacheName && key !== dynamicCacheName)
                .map(key => caches.delete(key))
            );
        })
    );
});

// Fetch Event
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request).then(cacheRes => {
            return cacheRes || fetch(event.request).then(response => {
                return caches.open(dynamicCacheName).then(function (cache) {
                    cache.put(event.request, response.clone());
                    return response;
                })
            });
        }).catch(function() {
            // Fallback Page, When No Internet Connection
            // return caches.match('offline.html');
        })
    );
});