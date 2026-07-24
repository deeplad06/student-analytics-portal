"🎓 Student Analytics Portal"

A web application developed using Laravel for managing students, faculty, subjects, and academic results.

# Features
-role-based login like(subject faculty, student)
-login dashboard
-student dasboard ( only view )
-faculty dashboard ( it cab edit and upadte student result)
-secure authentication
-result management

# Tech stack
- Laravel
- PHP
- MySQL
- Bootstrap 5
- HTML
- CSS
- JavaScript

# Installation

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan serve
