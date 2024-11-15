# Emailit Laravel Driver

[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE.md)

This PHP package provides a native mail driver for Laravel applications. Once installed and configured, Mailers are routed via the Emailit API.

# Table of Contents

* [Installation](#installation)
* [Thanks](#thanks)
* [License](#license)

<a name="installation"></a>
# Installation

## Requirements

- Laravel 10.0+
- PHP 8.0+
- Guzzle 7.0+
- An API Key from [emailit.com](https://www.emailit.com)

## Setup

You can install the package via composer:

```bash
composer require robkerry/emailit-laravel-driver
```

If you'd like to publish the config file, you can do that using:
```bash
php artisan vendor:publish --tag=emailit-config
```

Next, you need to set `EMAILIT_API_KEY` in your `.env` file:

```dotenv
EMAILIT_API_KEY=
```

And set the environment variable `MAIL_MAILER` in your `.env` file

```dotenv
MAIL_MAILER=emailit
```

Then, double check that your `FROM` data is filled in `.env`:

```dotenv
MAIL_FROM_ADDRESS=app@yourdomain.com
MAIL_FROM_NAME="App Name"
```

Lastly, add Emailit as a Laravel Mailer in `config/mail.php` in the `mailers` array:

```php
'emailit' => [
    'transport' => 'emailit',
],
```

<a name="thanks"></a>
# Thanks

This plugin is a fork of the [MailerSend](https://mailersend.com) package found here:
https://github.com/mailersend/mailersend-laravel-driver

Thank you to them for creating and MIT licensing it, so that I could use it for my current email provider.

<a name="license"></a>
# License

[The MIT License (MIT)](LICENSE.md)
