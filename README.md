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
use Endroid\PredictionIO\EventClient;
use Endroid\PredictionIO\EngineClient;

$apiKey = '...';
$eventClient = new EventClient($apiKey);
$recommendationEngineClient = new EngineClient('http://localhost:8000');
$similarProductEngineClient = new EngineClient('http://localhost:8001');

// Populate with users and items
$userProperties = ['address' => '1234 Street, San Francisco, CA 94107', 'birthday' => '22-04-1991'];
$eventClient->createUser('user_1', $userProperties);
$itemProperties = ['categories' => [123, 1234, 12345]];
$eventClient->createItem('product_1', $itemProperties);

// Record actions
$actionProperties = ['firstView' => true];
$eventClient->recordUserActionOnItem('view', 'user_1', 'product_1', $actionProperties);

// Return recommendations
$itemCount = 20;
$recommendedProducts = $recommendationEngineClient->getRecommendedItems('user_1', $itemCount);
$similarProducts = $similarProductEngineClient->getSimilarItems('product_1', $itemCount);

```

## Symfony integration

Register the Symfony bundle in the kernel.

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Endroid\PredictionIO\Bundle\EndroidPredictionIOBundle(),
    ];
}

```

The default parameters can be overridden via the configuration.

```yaml
endroid_prediction_io:
    event_server:
        url: http://localhost:7070
    apps:
        app_one:
            key: '...'
            engines:
                recommendation:
                    url: http://localhost:8000
                similarproduct:
                    url: http://localhost:8001
                viewedthenbought:
                    url: http://localhost:8002
                complementarypurchase:
                    url: http://localhost:8003
                productranking:
                    url: http://localhost:8004
                leadscoring:
                    url: http://localhost:8005
        app_two:
            key: '...'
            engines:
                complementarypurchase:
                    url: http://localhost:8006
                leadscoring:
                    url: http://localhost:8007
                    
```

Now you can retrieve the event and engine clients as follows.

```php
/** @var EventClient $eventClient */
$eventClient = $this->get('endroid.prediction_io.app_one.event_client');

/** @var EngineClient $recommendationEngineClient */
$recommendationEngineClient = $this->get('endroid.prediction_io.app_one.recommendation.engine_client');

/** @var EngineClient $similarProductEngineClient */
$similarProductEngineClient = $this->get('endroid.prediction_io.app_one.similarproduct.engine_client');

```

## Docker

Many Docker images exist for running a PredictionIO server. Personally I used the
[`spereio`](https://github.com/sphereio/docker-predictionio) image to create an image
that creates, trains and deploys a recommendation engine and starts the PIO server. You can find that
image in [`my personal Docker stack`](https://github.com/endroid/docker/tree/master/docker/prediction-io).

## Vagrant box

PredictionIO provides a [`Vagrant box`](https://docs.prediction.io/install/install-vagrant/)
containing an out-of-the-box PredictionIO server.

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatible
changes will be kept to a minimum but be aware that these can occur. Lock
your dependencies for production and test your code when upgrading.

## License

This bundle is under the MIT license. For the full copyright and license
information please view the LICENSE file that was distributed with this source code.