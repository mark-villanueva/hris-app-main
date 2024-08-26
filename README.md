
# HRIS using Laravel Filament

Make sure you have the latest versions of Nodejs ^18, PHP ^8.2, Composer, & MySQL ^8.0 installed in your device.

## Installation

To get started, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/mark-villanueva/hris-app-main.git
   ```

2. Navigate to the cloned directory:
   ```bash
   cd hris-app-main
   ```

3. Install Composer dependencies:
   ```bash
   composer install
   ```

4. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

5. Generate an application key:
   ```bash
   php artisan key:generate
   ```

6. Migrate the database:
   ```bash
   php artisan migrate
   ```

7. Generate Permissions and/or Policies for Filament entities
   ```bash
   php artisan shield:generate --all
   ```

8. Seed the Database:
   ```bash
   php artisan db:seed
   ```
   
9. Set the seeded credential as super_admin:
   ```bash
   php artisan shield:super-admin
   ```
   then choose admin@example.com or type 1

10. Serve the application:
   ```bash
   php artisan serve
   ```
   
11. Open /admin in your web browser, sign in using these credentials:
   ```bash
    Email: admin@example.com
    Password: password
   ```

This project is part of our OJT task 

