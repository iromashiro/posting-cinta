const CACHE_VERSION = 'posting-cinta-v2.0';
const STATIC_CACHE = `pc-static-${CACHE_VERSION}`;
const DYNAMIC_CACHE = `pc-dynamic-${CACHE_VERSION}`;
const IMAGE_CACHE = `pc-images-${CACHE_VERSION}`;
const OFFLINE_URL = '/offline';

const PRECACHE_URLS = [
  '/',
  OFFLINE_URL,
  '/manifest.webmanifest',
  'https://cdn.tailwindcss.com',
  'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js'
];

// Install - precache critical assets
self.addEventListener('install', (event) => {
  console.log('[SW] Installing service worker...');
  event.waitUntil((async () => {
    const cache = await caches.open(STATIC_CACHE);
    try {
      await cache.addAll(PRECACHE_URLS);
      console.log('[SW] Precached assets');
    } catch (error) {
      console.error('[SW] Precaching failed:', error);
    }
    self.skipWaiting();
  })());
});

// Activate - cleanup old caches
self.addEventListener('activate', (event) => {
  console.log('[SW] Activating service worker...');
  event.waitUntil((async () => {
    const keys = await caches.keys();
    await Promise.all(
      keys
        .filter(k => !k.includes(CACHE_VERSION))
        .map(k => {
          console.log('[SW] Deleting old cache:', k);
          return caches.delete(k);
        })
    );
    await self.clients.claim();
    console.log('[SW] Service worker activated');
  })());
});

// Helper: cache-first for static assets
async function cacheFirst(req) {
  const cached = await caches.match(req);
  if (cached) {
    console.log('[SW] Cache hit:', req.url);
    return cached;
  }

  try {
    const fresh = await fetch(req);
    if (fresh.ok) {
      const cache = await caches.open(STATIC_CACHE);
      cache.put(req, fresh.clone());
      console.log('[SW] Cached:', req.url);
    }
    return fresh;
  } catch (e) {
    console.error('[SW] Fetch failed:', req.url, e);
    return cached || Response.error();
  }
}

// Helper: network-first for pages (navigation)
async function networkFirst(req) {
  try {
    const fresh = await fetch(req);
    if (fresh.ok) {
      const cache = await caches.open(DYNAMIC_CACHE);
      cache.put(req, fresh.clone());
      console.log('[SW] Updated cache:', req.url);
    }
    return fresh;
  } catch (e) {
    console.error('[SW] Network failed, trying cache:', req.url);
    const cached = await caches.match(req);
    if (cached) return cached;

    // Fallback to offline page for navigations
    const offline = await caches.match(OFFLINE_URL);
    return offline || new Response('Offline - No cached content', {
      status: 503,
      headers: { 'Content-Type': 'text/plain' }
    });
  }
}

// Helper: cache images with stale-while-revalidate
async function cacheImages(req) {
  const cached = await caches.match(req);
  const fetchPromise = fetch(req).then(fresh => {
    if (fresh.ok) {
      const cache = caches.open(IMAGE_CACHE);
      cache.then(c => c.put(req, fresh.clone()));
    }
    return fresh;
  }).catch(() => cached);

  return cached || fetchPromise;
}

// Fetch event handler
self.addEventListener('fetch', (event) => {
  const req = event.request;

  // Only handle GET
  if (req.method !== 'GET') return;

  const url = new URL(req.url);
  const isSameOrigin = url.origin === self.location.origin;

  // Navigation requests: network-first with offline fallback
  if (req.mode === 'navigate') {
    console.log('[SW] Navigation:', url.pathname);
    event.respondWith(networkFirst(req));
    return;
  }

  // Images: cache with stale-while-revalidate
  if (req.destination === 'image') {
    event.respondWith(cacheImages(req));
    return;
  }

  // Static assets: cache-first
  const staticExt = ['.css', '.js', '.png', '.jpg', '.jpeg', '.svg', '.webp', '.ico', '.json', '.webmanifest', '.woff', '.woff2', '.ttf'];
  if (isSameOrigin && staticExt.some(ext => url.pathname.endsWith(ext))) {
    event.respondWith(cacheFirst(req));
    return;
  }

  // CDN assets: cache-first
  if (url.hostname.includes('cdn.')) {
    event.respondWith(cacheFirst(req));
    return;
  }

  // Default: try network, fallback cache
  event.respondWith((async () => {
    try {
      const fresh = await fetch(req);
      return fresh;
    } catch (e) {
      const cached = await caches.match(req);
      return cached || (req.mode === 'navigate' ?
        (await caches.match(OFFLINE_URL)) :
        Response.error()
      );
    }
  })());
});

// Handle messages from clients
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

// Background sync (future enhancement)
self.addEventListener('sync', (event) => {
  console.log('[SW] Background sync:', event.tag);
  if (event.tag === 'sync-measurements') {
    // Future: sync offline measurements
  }
});

// Push notifications (future enhancement)
self.addEventListener('push', (event) => {
  console.log('[SW] Push notification received');
  const data = event.data ? event.data.json() : {};
  const options = {
    body: data.body || 'Ada notifikasi baru',
    icon: '/icons/icon-192x192.png',
    badge: '/icons/icon-192x192.png',
    vibrate: [200, 100, 200],
    data: data
  };

  event.waitUntil(
    self.registration.showNotification(data.title || 'Posting Cinta', options)
  );
});
