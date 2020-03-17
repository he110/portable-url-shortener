# Standalone Url Shortener [![Build Status](https://travis-ci.com/he110/portable-url-shortener.svg?branch=master)](https://travis-ci.com/he110/portable-url-shortener)

[![Latest Stable Version](https://img.shields.io/packagist/v/he110/portable-url-shortener.svg)](https://packagist.org/packages/he110/portable-url-shortener) [![BCH compliance](https://bettercodehub.com/edge/badge/he110/portable-url-shortener?branch=master)](https://bettercodehub.com/)

Incredibly simple PHP-class, which saves your long URLs in Sqlite and returns short hashes.

## Installation

Install the latest version with

```bash
$ composer require he110/portable-url-shortener
```

## Basic Usage

### Save URL and get a hash

```php
<?php

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

## About

### Requirements

- Communication Tools works with PHP 7.1 or above.

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/he110/portable-url-shortener/issues)

### Author

Ilya S. Zobenko - <ilya@zobenko.ru> - <http://twitter.com/he110_todd>