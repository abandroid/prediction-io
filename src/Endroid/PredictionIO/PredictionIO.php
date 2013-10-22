<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\PredictionIO;

use Buzz\Browser;
use Buzz\Client\MultiCurl;
use PredictionIO\PredictionIOClient;

class PredictionIO
{
    /**
     * @var string
     */
    protected $apiUrl = 'http://localhost:8000/';

    /**
     * @var PredictionIOClient
     */
    protected $client;

    /**
     * Class constructor
     *
     * @param $apiKey
     * @param null $apiUrl
     */
    public function __construct($apiKey, $apiUrl = null)
    {
        $config = array('appkey' => $apiKey);

        if ($apiUrl) {
            $config['apiurl'] = $apiUrl;
        }

        $this->client = PredictionIOClient::factory($config);
    }
}