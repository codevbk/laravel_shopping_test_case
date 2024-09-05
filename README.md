# laravel_shopping_test_case

## 1. Clone the repository

`git clone https://github.com/codevbk/laravel_shopping_test_case.git`

## 2. cd into the project

`cd laravel_shopping_test_case`

## 3. Install dependencies

`composer install`
`npm install`

## 5. Copy the .env file

`cp .env.example .env`

## 6. Generate an app encryption key

`php artisan key:generate`

## 7. Migrate the database

`php artisan migrate`

## 8. Seed/Fill the database with sample datas

`php artisan db:seed --class=ProductSeeder`
`php artisan db:seed --class=UserSeeder`
`php artisan db:seed --class=CouponSeeder`
`php artisan db:seed --class=CouponProductSeeder`
`php artisan db:seed --class=CouponUserSeeder`

## 9. Running

`npm run dev`
`php artisan serve`

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
