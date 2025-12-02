<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FF6B8A">
    <title>500 - Kesalahan Server | {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-girly relative overflow-hidden">
    <!-- 🌸 Decorative Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="decorative-blob w-96 h-96 bg-primary-200 top-0 -right-48 animate-float"></div>
        <div class="decorative-blob w-80 h-80 bg-accent-200 bottom-20 -left-40" style="animation-delay: 2s;"></div>
        <div class="decorative-blob w-64 h-64 bg-secondary-200 top-1/3 right-1/4" style="animation-delay: 4s;"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative z-10">
        <div class="w-full max-w-lg text-center">
            <!-- Logo -->
            <div
                class="inline-flex items-center justify-center w-24 h-24 bg-gradient-primary rounded-3xl shadow-soft-lg mb-8 animate-float">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Error Card -->
            <div class="card-cute p-8">
                <!-- Error Code -->
                <h1 class="text-8xl font-bold bg-gradient-primary bg-clip-text text-transparent font-heading mb-4">500
                </h1>

                <!-- Message -->
                <h2 class="text-2xl font-bold text-neutral-800 font-heading mb-4">
                    Kesalahan Server 💔
                </h2>
                <p class="text-neutral-500 mb-8 font-medium">
                    Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang bekerja untuk memperbaikinya.
                    Silakan coba lagi dalam beberapa saat.
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="location.reload()" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Coba Lagi</span>
                    </button>
                    <a href="{{ url('/') }}" class="btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center gap-2 text-neutral-500 font-medium mb-2">
                    <span>Made with</span>
                    <svg class="w-5 h-5 text-primary-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <span>di Muara Enim</span>
                </div>
                <p class="text-xs text-neutral-400">
                    © {{ date('Y') }} {{ config('app.name') }} 💕
                </p>
            </div>
        </div>
    </div>
</body>

</html>