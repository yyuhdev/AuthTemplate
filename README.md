# Laravel Auth Template

**Laravel Auth Template** is a starter authentication setup for Laravel projects.
It includes **Login**, **Register**, **Logout**, and **Email Verification** powered by **Mailgun**.
Authentication is handled with **Sanctum** for secure API tokens.

## Table of Contents

* [Features](#features)
* [Prerequisites](#prerequisites)
* [Installation](#installation)
* [Usage](#usage)
* [Support & Contributing](#support--contributing)
* [License](#license)

## Features

* User authentication: Login, Register, Logout
* Email verification via Mailgun
* Sanctum API token authentication
* Symfony Mailer integration

## Prerequisites

* PHP 8.1+
* Laravel 12+
* Composer
* npm
* Mailgun account + API key
* Database (MySQL, PostgreSQL, or SQLite)

## Installation

```bash
git clone https://github.com/yourusername/laravel-auth-template.git
cd laravel-auth-template
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Configure `.env` with your Mailgun credentials:

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-mailgun-api-key
MAIL_FROM_ADDRESS=auth@example.com
MAIL_FROM_NAME="LaravelAuthTemplate"
```

## Usage

**Register** → Creates user & sends verification email
**Verify Email** → Activates user account
**Login** → Issues Sanctum token
**Logout** → Revokes token

## Support & Contributing

Contributions are welcome.
Use GitHub issues and pull requests to suggest improvements.

## License

This project is licensed under the [MIT License](LICENSE).
