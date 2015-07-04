PredictionIO
============

*By [endroid](http://endroid.nl/)*

[![Build Status](http://img.shields.io/travis/endroid/PredictionIO.svg)](http://travis-ci.org/endroid/PredictionIO)
[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/prediction-io.svg)](https://packagist.org/packages/endroid/prediction-io)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/prediction-io.svg)](https://packagist.org/packages/endroid/prediction-io)
[![License](http://img.shields.io/packagist/l/endroid/prediction-io.svg)](https://packagist.org/packages/endroid/prediction-io)

The PredictionIO library provides a client which offers easy access to a PredictionIO recommendation engine.
PredictionIO is an open source machine learning server for software developers to create predictive features, such as
personalization, recommendation and content discovery.

Through a small set of simple calls, all server functionality is exposed to your application. You can add users and items,
register actions between these users and items and retrieve recommendations deduced from this information by any
[`PredictionIO`](http://prediction.io/) recommendation engine. Applications range from showing recommended products in a
web shop to discovering relevant experts in a social collaboration network.

## Requirements

* Symfony
* Dependencies:
 * [`PredictionIO-PHP-SDK`](https://github.com/PredictionIO/PredictionIO-PHP-SDK)

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require endroid/prediction-io
```

## Usage

```php
<?php

use Endroid\PredictionIO\EventClient;
use Endroid\PredictionIO\EngineClient;

$eventClient = new EventClient($apiKey, $eventServerUrl);
$engineClient = new EngineClient($engineUrl);

// Populate with users and items
$userProperties = ['address' => '1234 Street, San Francisco, CA 94107', 'birthday' => '22-04-1991'];
$eventClient->createUser($userId, $userProperties);
$itemProperties = ['categories' => [123, 1234, 12345]];
$eventClient->createItem($itemId, $itemProperties);

// Record actions
$actionProperties = ['firstView' => true];
$eventClient->recordUserActionOnItem('view', $userId, $itemId, $actionProperties);

// Return recommendations
$itemCount = 20;
$recommendedItems = $engineClient->getRecommendedItems($userId, $itemCount);
$similarItems = $engineClient->getSimilarItems($itemId, $itemCount);
```

## Vagrant box

PredictionIO provides a [`Vagrant box`](https://docs.prediction.io/install/install-vagrant/)
containing an out-of-the-box PredictionIO server.

## Symfony

You can use [`EndroidPredictionIOBundle`](https://github.com/endroid/EndroidPredictionIOBundle)
to enable this service in your Symfony application.

## Versioning

Semantic versioning ([semver](http://semver.org/)) is applied as much as possible.

## License

This bundle is under the MIT license. For the full copyright and license information, please view the LICENSE file that
was distributed with this source code.
