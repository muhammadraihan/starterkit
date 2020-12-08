<p align="center"><img src="https://res.cloudinary.com/wba-indonesia/image/upload/v1598387833/logo_wba_dafkys.png" width="400"></p>

<p align="center">
</p>

# Starter Kit

## About

This is a starter kit to build application project using Laravel framework. This starter kit featured with access control system, and API ready to build backend or frontend. Admin dashboard is integrated with admin template. The purpose of this project is to cut the time of integrating template to laravel or setup authorization with access control list so developer can focus to build some awesome apps.

## What's New

- Now support laravel 8 and PHP 8. [Check changelog](CHANGELOG.md)

- Folder structure now using laravel 8 standard.

## Requirements

- PHP => 7.3

## Features

- Access Control List by spatie.
- Log Activity by spatie. (Please refer to existing models)
- API ready by JWT.
- Smartadmin templates already integrated.

## Usage

- Clone this repo
- Run composer install
- Copy .env.example to .env
- Configure .env file for database connection, etc
- Run php artisan key:generate
- Run php artisan jwt:secret
- Run php artisan db:seed --class=UserRoleTableSeeder
- Build something awesome !!!

## Admin Dashboard

Admin dashboard is using smartadmin template. Check this [link](https://www.gotbootstrap.com/themes/smartadmin/4.4.1/intel_analytics_dashboard.html) for full documentation. or clone this [repo](https://git.wbaindonesia.co/wbaindonesia/smartadmin-themes.git) and run locally to get more details about this template.

## Documentation

Still doesn't have. Maybe in the future.

## Contributing

We will talk about it later.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to WBA Indonesia via [devops@wbaindonesia.com](mailto:devops@wbaindonesia.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT) so this starter kit.