## About Laravel Mailbox

This project was created by, and is maintained by [Brian Faust](https://github.com/faustbrian), and is a package to intercept and process incoming emails within your Laravel application.. Be sure to browse through the [changelog](CHANGELOG.md), [code of conduct](.github/CODE_OF_CONDUCT.md), [contribution guidelines](.github/CONTRIBUTING.md), [license](LICENSE), and [security policy](.github/SECURITY.md).

> **Warning**
> This package is still in development and should not be used in production.

## Installation

> **Note**
> This package requires [PHP](https://www.php.net/) 8.2 or later, and it supports [Laravel](https://laravel.com/) 10 or later.

To get the latest version, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require bombenprodukt/laravel-mailbox
```

You can publish the configuration file by using:

```bash
$ php artisan vendor:publish --tag="laravel-mailbox-config"
```

## Usage

Please review the contents of [our test suite](/tests) for detailed usage examples.

## Drivers

> **Note**
> The `+` indicates that the driver is tested with a fixture.

> **Warning**
> The `!` indicates that the driver is not yet tested with a fixture.

```diff
! [Amazon SES](https://aws.amazon.com/ses/)
+ [Brevo](https://brevo.com)
! [MailCare](https://mailcare.io)
! [MailerSend](https://mailersend.com)
+ [Mailgun](https://mailgun.com)
+ [Mailjet](https://mailjet.com)
+ [Mandrill](https://mandrill.com)
+ [Postmark](https://postmark.com)
+ [SendGrid](https://sendgrid.com)
+ [SparkPost](https://sparkpost.com)
```
