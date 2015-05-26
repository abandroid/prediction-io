<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\PredictionIO;

use predictionio\EngineClient;
use predictionio\EventClient;

class Client
{
    /**
     * @var EventClient
     */
    protected $eventClient;

    /**
     * @var EngineClient
     */
    protected $engineClient;

    /**
     * Class constructor.
     *
     * @param EventClient  $eventClient
     * @param EngineClient $engineClient
     */
    public function __construct(EventClient $eventClient, EngineClient $engineClient)
    {
        $this->eventClient = $eventClient;
        $this->engineClient = $engineClient;
    }

    /**
     * Create a user.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function createUser($userId)
    {
        $response = $this->eventClient->createEvent(array(
            'event' => '$set',
            'entityType' => 'user',
            'entityId' => $userId,
        ));

        return $response;
    }

    /**
     * Create an item.
     *
     * @param $itemId
     * @param array $categories
     *
     * @return mixed
     */
    public function createItem($itemId, $categories = array())
    {
        $response = $this->eventClient->createEvent(array(
            'event' => '$set',
            'entityType' => 'item',
            'entityId' => $itemId,
            'properties' => array('categories' => $categories),
        ));

        return $response;
    }

    /**
     * Record a user action on an item.
     *
     * @param $userId
     * @param $itemId
     * @param string $action
     *
     * @return mixed
     */
    public function recordAction($userId, $itemId, $action = 'view')
    {
        $response = $this->eventClient->createEvent(array(
            'event' => $action,
            'entityType' => 'user',
            'entityId' => $userId,
            'targetEntityType' => 'item',
            'targetEntityId' => $itemId,
        ));

        return $response;
    }

    /**
     * Set specific items to unavailable.
     *
     * @param array $items
     *
     * @return string
     */
    public function setUnavailable(array $items)
    {
        $response = $this->eventClient->createEvent(array(
            'event' => '$set',
            'entityType' => 'constraint',
            'entityId' => 'unavailableItems',
            'properties' => array('items' => $items),
        ));

        return $response;
    }

    /**
     * Returns the recommendations for the given user.
     *
     * @param $userId
     * @param int $itemCount
     *
     * @return mixed
     */
    public function getRecommendedItems($userId, $itemCount = 3)
    {
        $response = $this->engineClient->sendQuery(array('user' => $userId, 'num' => $itemCount));

        return $response;
    }

    /**
     * Returns the items similar to the given item.
     *
     * @param $items
     * @param int $itemCount
     *
     * @return mixed
     */
    public function getSimilarItems($items, $itemCount = 3)
    {
        if (!is_array($items)) {
            $items = array($items);
        }

        $response = $this->engineClient->sendQuery(array('items' => $items, 'num' => $itemCount));

        return $response;
    }
}
