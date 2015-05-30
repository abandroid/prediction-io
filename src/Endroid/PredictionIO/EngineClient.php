<?php

namespace Endroid\PredictionIO;

use predictionio\EngineClient as BaseEngineClient;
use Endroid\PredictionIO\Model\CustomEvent;
use Endroid\PredictionIO\Model\EntityEvent;

/**
 * Class EngineClient
 *
 * @package Endroid\PredictionIO
 */
class EngineClient extends BaseEngineClient
{
    /**
     * @param string Base URL to the Engine Instance.
     * @param float  Timeout of the request in seconds. Use 0 to wait indefinitely
     * @param float  Number of seconds to wait while trying to connect to a server.
     */
    public function __construct($baseUrl, $timeout, $connectTimeout)
    {
        parent::__construct($baseUrl, $timeout, $connectTimeout);
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
        $response = $this->sendQuery(['user' => $userId, 'num' => $itemCount]);

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
            $items = array($items);
        }

        $response = $this->sendQuery(['items' => $items, 'num' => $itemCount]);

        return $response;
    }

}