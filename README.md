# Symfony2 Find Bundle

[![Build Status](https://travis-ci.org/mauro-moreno/find-bundle.svg?branch=master)](https://travis-ci.org/mauro-moreno/find-bundle)
[![Build Status](https://scrutinizer-ci.com/g/mauro-moreno/find-bundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mauro-moreno/find-bundle/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/mauro-moreno/find-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mauro-moreno/find-bundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mauro-moreno/find-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mauro-moreno/find-bundle/?branch=master)

Symfony2 Bundle for a PHP based find command.

## Installation

Using composer:

```bash
composer require mauro-moreno/find-bundle
```

Register Bundle in you app/AppKernel.php:

```php
// app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new MauroMoreno\FindBundle\FindBundle(),
        );

        // ...
    }
}
```

## Usage

As simple as using any app/console command.

```bash
app/console find:dir {pattern} {directory}
#ouput: file_1
```