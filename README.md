lf4php
======

master: [![Build Status](https://travis-ci.org/szjani/lf4php.png?branch=master)](https://travis-ci.org/szjani/lf4php)
3.0: [![Build Status](https://travis-ci.org/szjani/lf4php.png?branch=3.0)](https://travis-ci.org/szjani/lf4php)
4.0: [![Build Status](https://travis-ci.org/szjani/lf4php.png?branch=4.0)](https://travis-ci.org/szjani/lf4php)

This is a logging facade library. It wraps and hides logging frameworks thus you can whenever switch to another one. The idea came from slf4j which is a Java solution.

Features
--------

There is one implementation shipped with this package, the NOPLoggerFactory. It doesn't do anything.

Feel free to implement a binding for your preferred logging framework.

### Autofind implementation

You do not have to set the factory of your chosen framework if and only if only that implementation is available and that
is known by lf4php. Currently known implementations:

* [lf4php/lf4php-monolog](https://github.com/szjani/lf4php-monolog)
* [lf4php/lf4php-log4php](https://github.com/szjani/lf4php-log4php)
* [lf4php/lf4php-psr3](https://github.com/szjani/lf4php-psr3)
* [lf4php/lf4php-stdout] (https://github.com/szjani/lf4php-stdout) (You should use another implementation instead)

### NOPLoggerFactory

If you do not set a factory and there are not available any implementations, NOPLoggerFactory will be used by default.

### CachedClassLoggerFactory

It is recommended to extend this class when you create your own implementation. It provides two main features:
* It caches Logger objects by theirs name, so you will get the same Logger object with the same name.
* It supports Logger hierarchy which means you can use class names as logger names and it tries to find the closest logger
based on the exploded name.

  For instance, you configure a logger for a library named [mf4php] (http://github.com/szjani/mf4php). All classes coming from
  mf4php\\* namespace use Logger objects which names start with mf4php. In this case your configured logger will be used.

  It is highly recommended to use \__CLASS\__ keyword anytime you want to obtain a logger object.

### Message formatting

You can use parametrized messages. The '{}' pairs will be replaced with the corresponding item in the passed array.
The following two lines will yield the exact same output:

```php
$logger->debug('Hello ' . $name . ', welcome to ' . $where . '!');
$logger->debug('Hello {}, welcome to {}!', array($name, $where));
```

Using lf4php
------------

```php
<?php
// ... configure the logging framework and set factory
LoggerFactory::setILoggerFactory($factoryImplementation);

// Most implementations support logging hierarchy. You can use __CLASS__ keyword to obtain a logger.
$logger = LoggerFactory::getLogger('\foo\bar');
$logger->info('Message');
$logger->debug('Hello {}, are you {}?', array('John', 'ok'));
$logger->error(new \Exception());
```

History
-------

### 4.0

LazyMap (thanks Ocramius) has been introduced to store logger instances in `CachedClassLoggerFactory`. Its interface has been changed:
 - the root logger has to be passed to its constructor, the abstract `getDefaultLogger()` method has been removed
 - the `map` property became private
 - after calling the `getLogger()` method for the first time, no more logger can be registered, otherwise an `RuntimeException` is being thrown

### 3.0

Mustache based MessageFormatter has been modified to use slf4j style. For more information see the description above.
Thus Mustache is not a dependency anymore. Now message formatting is more than 4 times faster and log lines are shorter.
