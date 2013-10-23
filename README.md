Endroid PredictionIO Client
===========================

*By [endroid](http://endroid.nl/)*

[![Build Status](https://secure.travis-ci.org/endroid/PredictionIO.png)](http://travis-ci.org/endroid/PredictionIO)
[![Latest Stable Version](https://poser.pugx.org/endroid/prediction-io/v/stable.png)](https://packagist.org/packages/endroid/prediction-io)
[![Total Downloads](https://poser.pugx.org/endroid/prediction-io/downloads.png)](https://packagist.org/packages/endroid/prediction-io)

...

```php
<?php

$client = new Endroid\PredictionIO\PredictionIO($apiKey);

// populate
$client->createUser($userId);
$client->createItem($itemId);
$client->recordAction($userId, $itemId, 'view');

// get recommendations and similar items
$recommendations = $client->getRecommendations($userId, $engine, $count);
$similarItems = $client->getSimilarItems($itemId, $engine, $count);

```

## Vagrant box

PredictionIO provides a [`Vagrant box`](http://docs.prediction.io/current/installation/install-predictionio-with-virtualbox-vagrant.html)
containing an out-of-the-box PredictionIO server.

## Symfony

You can use [`EndroidPredictionIOBundle`](https://github.com/endroid/EndroidPredictionIOBundle) to enable this service in your Symfony application.

## License

This bundle is under the MIT license. For the full copyright and license information, please view the LICENSE file that
was distributed with this source code.
