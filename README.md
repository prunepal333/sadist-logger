SadistLogger
=============
Simple yet powerful PSR-3 compliant logger for PHP that is very minimal to use.
The best part about being PSR-3 compliant is that, you can replace this library
with existing PSR-3 Compliant library like Monolog(https://www.github.com/Seldaek/monolog) in its place when your project surpasses the needs fulfilled by this library.

Features
---------
* Simplicity
* PSR-3 Compliant
* Multiple Log Levels
* Custom Log messages
* Custom Contextual data

Setup
--------
Add the library to your `composer.json` file in your project:
```json
{
    "require": {
        "sadist/logger": "*"
    }
}
```

Use [composer](https://www.getcomposer.org) to install this library:
```bash
$ composer install
```

Composer will install SadistLogger inside your vendor folder. Then you can add the following to your php files to use the library with Autoloading.
```php
require_once "vendor/autoload.php"
```
Alternatively, use composer on the command line to require and install SadistLogger:
```
$ composer require "sadist/logger:*"
```

### Minimum Requirements:
* PHP 8.0

Usage
---------
```
$logfile = "/path/to/logfile.log"
$logLevel = "warning";
$logger = new \Sadist\Logger\SadistLogger($logfile, $loglevel);

$logger->error("Failed to upload data to the server!");
```
There are following log levels:
* None  `$logger->log('none', $message, $context);`
* Debug `$logger->debug($message, $context);`
* Info `$logger->info($message, $context);`
* Notice `$logger->notice($message, $context);`
* Warning `$logger->notice($message, $context);`
* Error `$logger->error($message, $context);`
* Critical `$logger->critical($message, $context);`
* Alert `$logger->alert($message, $context);`
* Emergency `$logger->emergency($message, $context);`

Note
----------
`$context` is optional parameter.

LogLevel of `none` will enable all other logs in the system.
