#!/bin/bash

# Posting Cinta - Setup Script
# Untuk Linux/Mac

echo "🚀 Posting Cinta - Setup Script"
echo "================================="
echo ""

# Check PHP
if ! command -v php &> /dev/null
then
    echo "❌ PHP tidak ditemukan. Install PHP 8.2+ terlebih dahulu."
    exit
fi

echo "✓ PHP version: $(php -v | head -n 1)"

# Check Composer
if ! command -v composer &> /dev/null
then
    echo "❌ Composer tidak ditemukan. Install Composer terlebih dahulu."
    exit
fi

echo "✓ Composer installed"
echo ""

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-interaction

# Copy .env if not exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    php artisan key:generate
else
    echo "✓ .env already exists"
fi

# Create icons directory
echo "📁 Creating directories..."
mkdir -p public/icons
mkdir -p public/screenshots

# Storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Run migrations
echo "🗄️  Running database migrations..."
read -p "Database configured in .env? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan migrate --force

    # Seed database
    read -p "Seed database with sample data? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]
    then
        php artisan db:seed --force
    fi
fi

echo ""
echo "✅ Setup completed!"
echo ""
echo "📋 Next steps:"
echo "1. Generate PWA icons (192x192 & 512x512) → save to public/icons/"
echo "2. Update .env with your database credentials"
echo "3. Run: php artisan migrate && php artisan db:seed"
echo "4. Run: php artisan serve"
echo "5. Open: http://localhost:8000"
echo ""
echo "👤 Default login:"
echo "   Email: kader@postingcinta.id"
echo "   Password: password"
echo ""
echo "📖 Read SETUP.md for detailed documentation"
