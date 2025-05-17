const staticCacheName = 'precache-v3.0.2';
const dynamicCacheName = 'runtimecache-v3.0.2';

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