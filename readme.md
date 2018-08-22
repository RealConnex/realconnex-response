# Realconnex HTTP Response package #

This is library for standard http responses

## Usage ##

```bash
$ composer require realconnex/http-response
```

```php
<?php
require_once "vendor/autoload.php";

$hello = new Realconnex\HttpResponse('test');
echo $hello->hello();
```

```bash
$ php test.php
```

It will print "Hello World!" then exit.
