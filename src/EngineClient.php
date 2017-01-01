<?php

namespace Endroid\PredictionIO;

use GuzzleHttp\Client;
use predictionio\EngineClient as BaseEngineClient;

/**
 * Class EngineClient.
 */
class EngineClient extends BaseEngineClient
{
    /**
     * @param string Base URL to the Engine Instance.
     * @param float  Timeout of the request in seconds. Use 0 to wait indefinitely
     * @param float  Number of seconds to wait while trying to connect to a server.
     */
    public function __construct($baseUrl = "http://localhost:8000", $timeout = 0, $connectTimeout = 5)
    {
        parent::__construct($baseUrl, $timeout, $connectTimeout);

        $this->client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => $timeout,
            'connect_timeout' => $connectTimeout,
            'verify' => false,
        ]);
    }

    /**
     * Returns the recommendations for the given user.
     *
     * @param string $userId
     * @param int    $itemCount
     *
     * @return string JSON response
     */
    public function getRecommendedItems($userId, $itemCount = 3)
    {
        $response = $this->sendQuery(['user' => $userId, 'num' => intval($itemCount)]);

        return $response;
    }

    /**
     * Returns the items similar to the given item.
     *
     * @param string $items
     * @param int    $itemCount
     *
     * @return string JSON response
     */
    public function getSimilarItems($items, $itemCount = 3)
    {
        if (!is_array($items)) {
            $items = [$items];
        }

        $response = $this->sendQuery(['items' => $items, 'num' => intval($itemCount)]);

        return $response;
    }
}
