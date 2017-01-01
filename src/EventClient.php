<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\PredictionIO;

use DateTime;
use predictionio\EventClient as BaseEventClient;
use Endroid\PredictionIO\Model\CustomEvent;
use Endroid\PredictionIO\Model\EntityEvent;

class EventClient extends BaseEventClient
{
    /**
     * @param string        $event
     * @param string        $entityType
     * @param string        $entityId
     * @param array         $properties
     * @param null|DateTime $eventTime
     *
     * @return string JSON response
     */
    public function createEntityEvent($event, $entityType, $entityId, array $properties = [], DateTime $eventTime = null)
    {
        $event = new EntityEvent($event, $entityType, $entityId);
        $event->setProperties($properties);
        $event->setEventTime($eventTime);
        $response = $this->createEvent($event->toArray());

        return $response;
    }

    /**
     * @param string        $event
     * @param string        $entityType
     * @param string        $entityId
     * @param string        $targetEntityType
     * @param string        $targetEntityId
     * @param array         $properties
     * @param null|DateTime $eventTime
     *
     * @return string JSON response
     */
    public function createCustomEvent($event, $entityType, $entityId, $targetEntityType, $targetEntityId, array $properties = [], DateTime $eventTime = null)
    {
        $event = new CustomEvent($event, $entityType, $entityId);
        $event->setProperties($properties);
        $event->setTargetEntityType($targetEntityType);
        $event->setTargetEntityId($targetEntityId);
        $event->setEventTime($eventTime);
        $response = $this->createEvent($event->toArray());

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
    public function createItem($itemId, $properties = [])
    {
        return $this->createEntityEvent('$set', 'item', $itemId, $properties);
    }

    /**
     * Record a user action on an item.
     *
     * @param string $action
     * @param string $userId
     * @param string $itemId
     * @param array  $properties
     * @param null   $eventTime
     *
     * @return string JSON response
     */
    public function recordUserActionOnItem($action = 'view', $userId, $itemId, array $properties = [], $eventTime = null)
    {
        return $this->createCustomEvent($action, 'user', $userId, 'item', $itemId, $properties, $eventTime);
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
}
