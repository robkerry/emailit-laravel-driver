# Emailit Laravel Driver

[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](./LICENSE.md)

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

After that, you need to set `EMAILIT_API_KEY` in your `.env` file:

```dotenv
EMAILIT_API_KEY=
```

Add Emailit as a Laravel Mailer in `config/mail.php` in `mailers` array:

```php
'emailit' => [
    'transport' => 'emailit',
],
```

And set environment variable `MAIL_MAILER` in your `.env` file

```dotenv
MAIL_MAILER=emailit
```

Also, double check that your `FROM` data is filled in `.env`:

```dotenv
MAIL_FROM_ADDRESS=app@yourdomain.com
MAIL_FROM_NAME="App Name"
```

<a name="thanks"></a>
# Thanks

This plugin is a fork of the [MailerSend](https://mailersend.com) package found here:
https://github.com/mailersend/mailersend-laravel-driver

Thank you to them for creating and MIT licensing it, so that I could use it for my current email provider.

<a name="license"></a>
# License

[The MIT License (MIT)](LICENSE.md)
