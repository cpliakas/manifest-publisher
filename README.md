# Manifest Publisher

[![Build Status](https://travis-ci.org/cpliakas/manifest-publisher.svg?branch=master)](https://travis-ci.org/cpliakas/manifest-publisher)
[![Code Coverage](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/cpliakas/manifest-publisher.svg)](http://hhvm.h4cc.de/package/cpliakas/manifest-publisher)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/cpliakas/manifest-publisher/v/stable.svg)](https://packagist.org/packages/cpliakas/manifest-publisher)
[![License](https://poser.pugx.org/cpliakas/manifest-publisher/license.svg)](https://packagist.org/packages/cpliakas/manifest-publisher)

Manifest Publisher is a CLI tool that automatically generates and publishes the
`manifest.json` file used by the [Phar Update](https://github.com/herrera-io/php-phar-update)
library in order to add self update capabilities to your [phar](http://php.net/manual/en/intro.phar.php).
The `manifest.json` file can be published to various targets such as [GitHub Pages](https://pages.github.com/).

## Background

Distributing a CLI application as a [phar](http://php.net/manual/en/intro.phar.php)
is surprisingly simple thanks to the excellent work of [Kevin Herrera](https://github.com/kherge)
on the [Box](https://github.com/herrera-io/php-box) project. He even took it a
step further and made it trivial to implement self-update capabilities similar
to Composer's `composer self-update` command so that your users can keep the
application up to date. Refer to the [Distributing a PHP CLI app with ease](http://moquet.net/blog/distributing-php-cli/)
blog post by [Matthieu Moquet](https://github.com/MattKetmo) for a detailed
walkthrough of the [Phar Update](https://github.com/herrera-io/php-phar-update)
tool. This project picks up where the blogs post leaves off and provides a more
robust tool that automatically generates and publishes the `manifest.json` file
to various targets.

## Installation

Manifest Publisher can be installed with [Composer](http://getcomposer.org)
by adding it as a dependency to your project's composer.json file.

```json
{
    "require": {
        "cpliakas/manifest-publisher": "*"
    }
}
```

Please refer to [Composer's documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction)
for more detailed installation and usage instructions.

## Usage

`php manifest.phar publish:gh-pages vendor/repository`
