# AHP dan Djikstra pada Toko Laptop Online
Tugas Kuliah Program Pascasarjana Universitas Handayani Makassar mata kuliah Rekayasa Perangkat Lunak untuk mendemonstrasikan implementasi algoritma AHP (Analytical Hierarchy Process) dan Djikstra dalam stusi kasus Toko Laptop Online

### Project's Description

This project (repository) is a Laravel based for toko laptop online.

## Prerequisites

Below is minimum requirements and instruction on how to run this project in your development environment.

### Server

1. PHP >= 8.4.2
2. BCMath PHP Extension.
3. Ctype PHP Extension.
4. Fileinfo PHP Extension.
5. JSON PHP Extension.
6. Mbstring PHP Extension.
7. OpenSSL PHP Extension.
8. PDO PHP Extension.
9. MySQL or MariaDB or Sqlite
10. Composer >= 2.8.8
11. GIT v2.39.5
12. Node v23.7.0

### How to run the project

1. Clone the [repository](https://github.com/kqha/tugas_rpl.git) to a new folder and then checkout to "
   develop" branch.
2. Run `composer install`.
3. Copy .env.example to .env.
4. Open the .env file and fill out your DB information.
5. Run `npm install`.
6. Run `npm run build`.
7. Run `php artisan migrate`.
8. Run `php artisan db:seed`.
9. To run it with Laravel server run `php artisan serve`.
### Code style

We are using
the [PSR-4 autoloading standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md),
meaning that for classes, methods, and code structure are using the standard to make the interoperability from composer
is well applied.

More information can be found [here](https://laravel.com/docs/9.x/contributions#coding-style), regarding stuffs like
PHPDoc and StyleCI.
