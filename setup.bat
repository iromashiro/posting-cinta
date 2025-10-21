@echo off
REM Posting Cinta - Setup Script
REM Untuk Windows

echo ========================================
echo   Posting Cinta - Setup Script
echo ========================================
echo.

REM Check PHP
where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [X] PHP tidak ditemukan. Install PHP 8.2+ terlebih dahulu.
    pause
    exit /b
)
echo [OK] PHP terdeteksi

REM Check Composer
where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo [X] Composer tidak ditemukan. Install Composer terlebih dahulu.
    pause
    exit /b
)
echo [OK] Composer terdeteksi
echo.

REM Install dependencies
echo [*] Installing dependencies...
call composer install --no-interaction
echo.

REM Copy .env
if not exist .env (
    echo [*] Creating .env file...
    copy .env.example .env
    php artisan key:generate
) else (
    echo [OK] .env already exists
)
echo.

REM Create directories
echo [*] Creating directories...
if not exist public\icons mkdir public\icons
if not exist public\screenshots mkdir public\screenshots
echo.

REM Storage link
echo [*] Creating storage link...
php artisan storage:link
echo.

REM Migrations prompt
echo [*] Database migrations
set /p run_migrate="Database sudah dikonfigurasi di .env? (y/n): "
if /i "%run_migrate%"=="y" (
    php artisan migrate --force

    set /p run_seed="Seed database dengan data sample? (y/n): "
    if /i "%run_seed%"=="y" (
        php artisan db:seed --force
    )
)
echo.

echo ========================================
echo   Setup Selesai!
echo ========================================
echo.
echo Langkah selanjutnya:
echo 1. Generate PWA icons (192x192 ^& 512x512) ke public\icons\
echo 2. Update .env dengan kredensial database
echo 3. Run: php artisan migrate ^&^& php artisan db:seed
echo 4. Run: php artisan serve
echo 5. Buka: http://localhost:8000
echo.
echo Login default:
echo    Email: kader@postingcinta.id
echo    Password: password
echo.
echo Baca SETUP.md untuk dokumentasi lengkap
echo.
pause
