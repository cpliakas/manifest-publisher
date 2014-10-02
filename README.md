# Manifest Publisher

[![Build Status](https://travis-ci.org/cpliakas/manifest-publisher.svg?branch=master)](https://travis-ci.org/cpliakas/manifest-publisher)
[![Code Coverage](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/cpliakas/manifest-publisher.svg)](http://hhvm.h4cc.de/package/cpliakas/manifest-publisher)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cpliakas/manifest-publisher/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/cpliakas/manifest-publisher/v/stable.svg)](https://packagist.org/packages/cpliakas/manifest-publisher)
[![License](https://poser.pugx.org/cpliakas/manifest-publisher/license.svg)](https://packagist.org/packages/cpliakas/manifest-publisher)

Want to implement and sustain a self-update capability in your [phar](http://php.net/manual/en/intro.phar.php)
that is similar to Composer's [self-update](https://getcomposer.org/doc/03-cli.md#self-update)
command?

Manifest Publisher is a CLI tool that builds on top of the [Box](https://github.com/herrera-io/php-box)
and [Phar Update](https://github.com/herrera-io/php-phar-update) projects in
order to make it easy to implement and sustain a self-update capability in your
phar. From a technical standpoint, it automatically generates and publishes the
`manifest.json` file used by the [Phar Update](https://github.com/herrera-io/php-phar-update)
library to determine when an update is available for your application. The
`manifest.json` file can be published to various targets, usually [GitHub Pages](https://pages.github.com/).

## Background

Distributing a CLI application as a phar is surprisingly simple thanks to the
excellent work of [Kevin Herrera](https://github.com/kherge) on the [Box](https://github.com/herrera-io/php-box)
project. He even took it a step further and made it trivial to implement
a self-update capability similar to Composer's `php composer.phar self-update`
command so that your users can easily keep the application up to date. Refer to
the [Distributing a PHP CLI app with ease](http://moquet.net/blog/distributing-php-cli/)
blog post by [Matthieu Moquet](https://github.com/MattKetmo) for a detailed
walkthrough of the [Phar Update](https://github.com/herrera-io/php-phar-update)
tool. This project picks up where the blog post leaves off and provides a more
robust tool that automatically generates and publishes the `manifest.json` file
to various targets.

## Installation

Download the `manifest.phar` file from [https://github.com/cpliakas/manifest-publisher/releases](https://github.com/cpliakas/manifest-publisher/releases)

## Usage

Generate the `manifest.json` for the `vendor/repository` project and publish it
to GitHub Pages.

* `php manifest.phar publish:gh-pages vendor/repository`

Update the `manifest.phar` application to the latest stable version (Yes, this
project [drinks its own champagne](http://en.wikipedia.org/wiki/Eating_your_own_dog_food#Criticism_and_alternative_terms)).

* `php manifest.phar self-update`

## Assumptions

* You are acting on a repository hosted on [GitHub](https://github.com/) that you have push access to
* A `box.json` file is present in the project's root directory
* The `gh-pages` branch has been set up according to [GitHub's documentation](https://help.github.com/articles/creating-project-pages-manually)
* The phar is distributed via [GitHub Releases](https://github.com/blog/1547-release-your-software)
  with tag names exactly matching the corresponding VCS tags
