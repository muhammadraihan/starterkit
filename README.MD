<p align="center"><img src="https://res.cloudinary.com/wba-indonesia/image/upload/v1598387833/logo_wba_dafkys.png" width="400"></p>

<p align="center">
</p>

# Starter Kit

## About

This is a starter kit to build application using Laravel framework. This kit featured with access control system and API ready to build backend and frontend. Dashboard frontend is integrated with smartadmin template. The purpose of this project is to cut the time of integrating template to laravel and setup authorization with access control list so developer can focus to build some awesome apps.

## Release Notes

- [release notes](CHANGELOG.md)

## Requirements

- PHP >= 7.3

## Basic Features

- HTML and Form generator by [LaravelCollective](https://github.com/LaravelCollective/html)
- Access Control List by [spatie laravel permission](https://github.com/spatie/laravel-permission)
- Log Activity by [spatie activity log](https://github.com/spatie/laravel-activitylog)
- Datatables by [yajra datatable](https://github.com/yajra/laravel-datatables)
- UUID generator by [webpatser](https://github.com/webpatser/laravel-uuid)
- API token auth by [jwt-aut](https://github.com/tymondesigns/jwt-auth)
- SmartAdmin templates by [gotbootstrap](https://www.gotbootstrap.com/)

## Usage

- Copy .env.example to .env
- Configure database and other info in .env file
- Open terminal and prompt to project root directory
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan jwt:secret`
- Run `php artisan db:seed --class=StarterDataSeeder`
- Build something awesome !!!

## SmartAdmin Template

This dashboard frontend is using smartadmin template. Check this [link](https://www.gotbootstrap.com/themes/smartadmin/4.4.1/intel_analytics_dashboard.html) for full documentation and information.

## Documentation

Still doesn't have. Maybe in the future.

## Contributing

We will talk about it later.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to WBA Indonesia via [devops@wbaindonesia.com](mailto:devops@wbaindonesia.com). All security vulnerabilities will be promptly addressed.

## License

- The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT) so this starter kit but not included admin template.
- SmartAdmin dashboard template is proprietary software so please refer to this [link](https://www.gotbootstrap.com/) for futher information.
