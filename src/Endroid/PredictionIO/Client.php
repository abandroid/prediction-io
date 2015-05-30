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
use Endroid\PredictionIO\Model\CustomEvent;
use Endroid\PredictionIO\Model\EntityEvent;

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
        $this->eventClient  = $eventClient;
        $this->engineClient = $engineClient;
    }

    /**
     * @param string           $event
     * @param string           $entityType
     * @param string           $entityId
     * @param array            $properties
     * @param null | \DateTime $eventTime
     *
     * @return string JSON response
     */
    public function createEntityEvent(
        $event,
        $entityType,
        $entityId,
        array $properties = [],
        \DateTime $eventTime = null)
    {
        $event = new EntityEvent($event, $entityType, $entityId);
        $event->setProperties($properties);
        $event->setEventTime($eventTime);
        $response = $this->eventClient->createEvent($event->toArray());

        return $response;
    }

    /**
     * @param string         $event
     * @param string         $entityType
     * @param string         $entityId
     * @param string         $targetEntityType
     * @param string         $targetEntityId
     * @param array          $properties
     * @param null|\DateTime $eventTime
     *
     * @return string JSON response
     */
    public function createCustomEvent(
        $event,
        $entityType,
        $entityId,
        $targetEntityType,
        $targetEntityId,
        array $properties = [],
        \DateTime $eventTime = null)
    {
        $event = new CustomEvent($event, $entityType, $entityId);
        $event->setProperties($properties);
        $event->setTargetEntityType($targetEntityType);
        $event->setTargetEntityId($targetEntityId);
        $event->setEventTime($eventTime);
        $response = $this->eventClient->createEvent($event->toArray());

        return $response;
    }

    /**
     * Create a user.
     *
     * @param string $userId
     * @param array  $properties
     *
     * @return string JSON response
     */
    public function createUser($userId, array $properties = [])
    {
        return $this->createEntityEvent('$set', 'user', $userId, $properties);
    }

    /**
     * Create an item.
     *
     * @param string $itemId
     * @param array  $properties
     *
     * @return string JSON response
     */
    public function createItem($itemId, $properties = array())
    {
        return $this->createEntityEvent('$set', 'item', $itemId, $properties);
    }

    /**
     * Record a user action on an item.
     *
     * @param string $userId
     * @param string $itemId
     * @param string $action
     * @param array  $properties
     *
     * @return string JSON response
     */
    public function recordUserActionOnItem($userId, $itemId, $action = 'view', $properties = [])
    {
        return $this->createCustomEvent($action, 'user', $userId, 'item', $itemId, $properties);
    }

    /**
     * Set specific items to unavailable.
     *
     * @param array $items
     *
     * @return string JSON response
     */
    public function setUnavailableItems(array $items)
    {
        return $this->createEntityEvent('$set', 'constraint', 'unavailableItems', ['items' => $items]);
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
        $response = $this->engineClient->sendQuery(['user' => $userId, 'num' => $itemCount]);

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

        $response = $this->engineClient->sendQuery(['items' => $items, 'num' => $itemCount]);

        return $response;
    }

    /**
     * @return EngineClient
     */
    public function getEngineClient()
    {
        return $this->engineClient;
    }

    /**
     * @return EventClient
     */
    public function getEventClient()
    {
        return $this->eventClient;
    }
}
