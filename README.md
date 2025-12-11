# 🏔️ GoSummit - Mountain Ticketing System

A comprehensive web-based e-ticketing platform for mountain climbing and hiking activities, built with Laravel 10. This system provides seamless booking management, multi-language support, and integrated payment processing for outdoor adventure enthusiasts.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [System Requirements](#-system-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [API Integration](#-api-integration)
- [Testing](#-testing)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🎫 Core Functionality
- **Online Booking System** - Real-time ticket booking with quota management
- **Multi-Mountain Support** - Manage multiple mountains and trail routes
- **Dynamic Pricing** - Flexible pricing based on visitor type and season
- **QR Code Tickets** - Automated QR code generation for ticket validation
- **Quota Management** - Daily quota tracking and availability checking

### 👥 User Management
- **Multi-Role System** - Customer, Admin, and Validator roles
- **Social Authentication** - Login via Google and Facebook OAuth
- **User Profiles** - Comprehensive user profile management
- **Saved Members** - Quick booking with saved member information

### 💳 Payment & Vouchers
- **Midtrans Integration** - Secure payment gateway integration
- **Voucher System** - Discount codes with usage tracking
- **Multiple Payment Methods** - Support for various payment channels
- **Transaction History** - Complete booking and payment records

### 🌐 Internationalization
- **Multi-Language Support** - Indonesian and English interface
- **Dynamic Translation** - Real-time language switching
- **Localized Content** - Translated mountain descriptions and news

### 📊 Admin Dashboard
- **Analytics Dashboard** - Booking statistics and revenue tracking
- **Mountain Management** - CRUD operations for mountains and routes
- **News Management** - Content management system for news articles
- **Booking Management** - View and manage all bookings
- **Notification System** - Admin notifications for important events

### 🌤️ Additional Features
- **Weather Integration** - Real-time weather data via OpenWeatherMap API
- **PDF Ticket Generation** - Downloadable PDF tickets with QR codes
- **Responsive Design** - Mobile-friendly interface with TailwindCSS
- **Livewire Components** - Dynamic, reactive UI components
- **Image Galleries** - Mountain photo galleries with lightbox

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 10.x
- **PHP Version:** 8.1+
- **Database:** MySQL
- **Authentication:** Laravel Sanctum, Laravel Socialite

### Frontend
- **CSS Framework:** TailwindCSS 3.x
- **JavaScript:** Alpine.js
- **UI Components:** Livewire 3.x
- **Icons:** Font Awesome / Heroicons

### Key Packages
- **Payment:** Midtrans PHP SDK
- **PDF Generation:** DomPDF
- **QR Codes:** SimpleSoftwareIO Simple QR Code
- **HTTP Client:** Guzzle
- **Testing:** Pest PHP

## 💻 System Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16.x & NPM
- MySQL >= 5.7 or MariaDB >= 10.3
- Git

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/fairuzjs/gosummit-laravel.git
cd gosummit-laravel
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit `.env` file and configure the following:

```env
# Application
APP_NAME="GoSummit"
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gosummit_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Weather API (OpenWeatherMap)
WEATHER_API_KEY=your_openweathermap_api_key

# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret

# Facebook OAuth
FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret

# Midtrans Payment
MIDTRANS_SERVER_KEY=your_midtrans_server_key
MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 5. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed database with sample data (optional)
php artisan db:seed
```

### 6. Storage Setup

```bash
# Create symbolic link for storage
php artisan storage:link
```

### 7. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Run the Application

```bash
# Start development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## ⚙️ Configuration

### Social Authentication Setup

#### Google OAuth
1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create a new project or select existing
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized redirect URI: `http://localhost:8000/auth/google/callback`
6. Copy Client ID and Secret to `.env`

#### Facebook OAuth
1. Go to [Facebook Developers](https://developers.facebook.com)
2. Create a new app
3. Add Facebook Login product
4. Configure OAuth redirect URI: `http://localhost:8000/auth/facebook/callback`
5. Copy App ID and Secret to `.env`

### Payment Gateway Setup (Midtrans)

1. Register at [Midtrans](https://midtrans.com)
2. Get your Server Key and Client Key from dashboard
3. For testing, use Sandbox credentials
4. Add keys to `.env` file

### Weather API Setup

1. Register at [OpenWeatherMap](https://openweathermap.org/api)
2. Get your API key
3. Add to `.env` as `WEATHER_API_KEY`

## 📖 Usage

### Default User Roles

After seeding, you can use these default accounts:

```
Admin:
Email: admin@gosummit.com
Password: password

Customer:
Email: customer@gosummit.com
Password: password

Validator:
Email: validator@gosummit.com
Password: password
```

### Key Workflows

#### Customer Booking Flow
1. Browse available mountains
2. Select mountain and trail route
3. Choose booking date and add members
4. Apply voucher code (optional)
5. Proceed to payment
6. Receive QR code ticket via email and download

#### Admin Management
1. Login to admin dashboard
2. Manage mountains, routes, and quotas
3. View booking statistics
4. Create and manage news articles
5. Monitor notifications

#### Validator Operations
1. Scan QR code from customer ticket
2. Validate ticket authenticity
3. Mark ticket as used

## 📁 Project Structure

```
gosummit-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin panel controllers
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   └── Validator/      # Validator controllers
│   │   ├── Middleware/         # Custom middleware
│   │   └── Livewire/           # Livewire components
│   ├── Models/                 # Eloquent models
│   └── Services/               # Business logic services
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin views
│   │   ├── auth/               # Authentication views
│   │   ├── components/         # Blade components
│   │   ├── livewire/           # Livewire views
│   │   └── layouts/            # Layout templates
│   ├── css/                    # Stylesheets
│   └── js/                     # JavaScript files
├── routes/
│   ├── web.php                 # Web routes
│   ├── api.php                 # API routes
│   └── auth.php                # Authentication routes
├── public/                     # Public assets
├── storage/                    # File storage
└── tests/                      # Test files
```

## 🔌 API Integration

### Weather API

The system integrates with OpenWeatherMap API to display real-time weather conditions for each mountain location.

```php
// Example usage in WeatherService
$weather = app(WeatherService::class)->getWeather($latitude, $longitude);
```

### Payment Gateway (Midtrans)

Midtrans integration for secure payment processing:

```php
// Create transaction
$params = [
    'transaction_details' => [
        'order_id' => $booking->booking_code,
        'gross_amount' => $booking->total_price,
    ],
    // ... other parameters
];

$snapToken = \Midtrans\Snap::getSnapToken($params);
```

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingTest.php

# Run with coverage
php artisan test --coverage
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Fairuz JS**
- GitHub: [@fairuzjs](https://github.com/fairuzjs)

## 🙏 Acknowledgments

- Laravel Framework
- TailwindCSS
- Livewire
- Midtrans
- OpenWeatherMap
- All contributors and supporters

## 📞 Support

For support, email support@gosummit.com or open an issue in the GitHub repository.

---

**Made with ❤️ for mountain enthusiasts**
