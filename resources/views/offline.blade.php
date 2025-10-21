<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ec4899">
    <title>Offline - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Offline Icon -->
        <div
            class="mb-8 inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full shadow-2xl">
            <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
            </svg>
        </div>

        <!-- Message Card -->
        <div class="card-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Anda Sedang Offline</h1>
            <p class="text-gray-600 mb-6">
                Sepertinya tidak ada koneksi internet. Beberapa fitur mungkin tidak tersedia saat ini.
            </p>

            <!-- Tips -->
            <div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl p-6 text-left mb-6">
                <div class="flex items-start gap-3 mb-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-2">Tips Saat Offline:</h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>✓ Data yang sudah dibuka masih bisa dilihat</li>
                            <li>✓ Perubahan akan tersimpan otomatis</li>
                            <li>✓ Sinkronisasi saat koneksi kembali</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button onclick="location.reload()" class="btn-primary w-full">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Coba Lagi
                    </div>
                </button>

                <a href="/" class="btn-secondary block w-full text-center">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-sm text-gray-500">
            <p>{{ config('app.name') }}</p>
            <p class="mt-1">Aplikasi PWA - Bisa Digunakan Offline</p>
        </div>
    </div>

    <script>
        // Auto-reload when online
        window.addEventListener('online', () => {
            location.reload();
        });

        // Show connection status
        if (navigator.onLine) {
            // If somehow online, redirect to home
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
        }
    </script>
</body>

</html>
