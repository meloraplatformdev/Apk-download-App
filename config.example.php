<?php
/**
 * APK SZ Store Configuration File
 * Copy this file to config.php and update values as needed
 */

// Application Settings
define('APP_NAME', 'APK SZ Store & Developer Console');
define('APP_VERSION', '1.0.0');
define('APP_DESCRIPTION', 'Safe Android APK Market - Download the Best Apps');

// Storage Configuration
define('STORAGE_TYPE', 'local'); // 'local' or 'database'
define('STORAGE_DIR', __DIR__ . '/data');

// Database Configuration (Optional - for future use)
define('DB_TYPE', 'mysql'); // 'mysql', 'sqlite', 'pgsql'
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'apk_store');
define('DB_USER', 'root');
define('DB_PASS', '');

// API Configuration
define('API_RATE_LIMIT', 100); // requests per hour
define('API_TIMEOUT', 30); // seconds

// Security
define('ENABLE_CORS', true);
define('ALLOWED_ORIGINS', ['*']); // Set specific domains in production
define('ENABLE_API_AUTH', false); // Set to true for production
define('API_KEY', 'your-secret-api-key');

// Social Links (Default values)
define('TELEGRAM_LINK', 'https://t.me/');
define('YOUTUBE_LINK', 'https://youtube.com/');

// File Upload
define('MAX_UPLOAD_SIZE', 1024 * 1024 * 50); // 50 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Logging
define('ENABLE_LOGGING', true);
define('LOG_DIR', __DIR__ . '/logs');
define('LOG_LEVEL', 'info'); // 'debug', 'info', 'warning', 'error'

// Email Notifications (Optional)
define('ENABLE_EMAIL_NOTIFICATIONS', false);
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('ADMIN_EMAIL', 'admin@example.com');

// Caching
define('ENABLE_CACHE', false);
define('CACHE_DURATION', 3600); // seconds

// Analytics (Optional)
define('ENABLE_ANALYTICS', false);
define('ANALYTICS_ID', ''); // Google Analytics ID

// Environment
define('ENVIRONMENT', 'development'); // 'development' or 'production'
define('DEBUG_MODE', ENVIRONMENT === 'development');

// Timezone
define('TIMEZONE', 'UTC');
date_default_timezone_set(TIMEZONE);
?>
