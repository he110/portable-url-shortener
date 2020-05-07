# Standalone Url Shortener [![Build Status](https://travis-ci.com/he110/portable-url-shortener.svg?branch=master)](https://travis-ci.com/he110/portable-url-shortener)

[![Latest Stable Version](https://img.shields.io/packagist/v/he110/portable-url-shortener.svg)](https://packagist.org/packages/he110/portable-url-shortener) [![BCH compliance](https://bettercodehub.com/edge/badge/he110/portable-url-shortener?branch=master)](https://bettercodehub.com/)

Incredibly simple PHP-class, which saves your long URLs in Sqlite and returns short hashes.

## Installation

Install the latest version with

```bash
$ composer require he110/portable-url-shortener
```

Or if you have cloned whole repo, do not forget to use composer install command.

```bash
$ composer install
```

## Basic Usage

### Save URL and get a hash

```php
<?php

require_once 'vendor/autoload.php';

use He110\UrlShortener\Shortener;

$pathToDatabaseFile = 'file_will_be_created.db';

$service = new Shortener($pathToDatabaseFile);

$url = 'https://very.long/and/#ugly?url=which&you=want&make=shorter';
$hash = $service->generateHash($url); // lQc2f9

echo sprintf('https://your-new.url/go/%s', $hash); 
// https://your-new.url/go/lQc2f9

```

### Get long URL back by the hash

```php
<?php

require_once 'vendor/autoload.php';

use He110\UrlShortener\Shortener;

$pathToDatabaseFile = 'file_will_be_created.db';

$service = new Shortener($pathToDatabaseFile);

if ($url = $service->getFullUrl('lQc2f9')) {
    echo $url;
    // https://very.long/and/#ugly?url=which&you=want&make=shorter
} else {
    echo 'Url with such hash doesn\' exists. So, method returned null';
}

```

### How to control hash minimal hash length

By default length is set to `4`. But you can change it via default object constructor or using `setHashLength` method. 

```php
<?php

require_once 'vendor/autoload.php';

use He110\UrlShortener\Shortener;

$pathToDatabaseFile = 'file_will_be_created.db';

// Second arg for hash length
$service = new Shortener($pathToDatabaseFile, 10);

$url = 'https://very.long/and/#ugly?url=which&you=want&make=shorter';
$hash = $service->generateHash($url); // WjnegYbwZ1

$service->setHashLength(15);
$url = 'https://another.long/and/#ugly?url=which&you=want&make=shorter';
$hash = $service->generateHash($url); // LkQWjnegYbwZ1p0

```

## About

### Requirements

- Communication Tools works with PHP 7.2 or above.

- mbstring

- pdo-sqlite

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/he110/portable-url-shortener/issues)

### Author

Elijah S. Zobenko - <ilya@zobenko.ru> - <http://twitter.com/he110_todd>
