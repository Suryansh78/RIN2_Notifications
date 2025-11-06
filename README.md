# RIN2 - Notifications

## Requirements
- PHP 8.2+
- Composer
- Laravel 10
- MySQL or Postgres

## Installation (example with MySQL)

1. Clone repo:
   ```bash
   git clone <your-repo> rin2
   cd rin2

2. Install composer dependencies:
composer install

3. Copy env and set DB credentials:
cp .env.example .env
# edit .env: DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan key:generate

4. Run migrations and seeders:
php artisan migrate
php artisan db:seed --class=UsersTableSeeder
php artisan db:seed --class=NotificationsSeeder

5. (Optional) Install phone validator:
composer require propaganistas/laravel-phone

6. Run locally:
php artisan serve