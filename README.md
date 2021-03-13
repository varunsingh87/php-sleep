# PHP Sleep

An object-oriented PHP library for a simple REST service

PHP Sleep is a PHP library for creating JSON-based REST APIs that interact with a MySQL database.

## Getting Started

The library uses PHP's `$_ENV` superglobal to access the environmental variables. 
For this reason, PHP Sleep is only guaranteed to work when using [Vercel](vercel.com/) as the hosting platform and [vercel-php](https://github.com/juicyfx/vercel-php) as the runtime. If you have not already, switch to Vercel and vercel-php and make sure your `now.json` file is valid.

## Usage

1. Make sure [Composer](https://getcomposer.org/) is installed

2. Run `composer require varuns/php-sleep`

## Contributing

So you'd like to contribute to the PHP Sleep library? Excellent! Thank you very much. I can absolutely use your help. Follow the steps below:

1. Read [the contributing guidelines](CONTRIBUTING.md).
2. Open an issue or pull request preferably using an existing template