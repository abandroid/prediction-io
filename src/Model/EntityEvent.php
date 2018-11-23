<?php

declare(strict_types=1);

namespace Endroid\PredictionIo\Model;

/**
 * Class EntityEvent.
 */
class EntityEvent extends AbstractEvent
{
    public static $AVAILABLE_EVENTS = ['$set', '$unset', '$delete'];

    /**
     * @param string $event
     * @param string $entityType
     * @param string $entityId
     */
    public function __construct($event, $entityType, $entityId)
    {
        $this->checkEvent($event);
        parent::__construct($event, $entityType, $entityId);
        $this->setEventType(self::EVENT_TYPE_ENTITY);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTargetEntity()
    {
        return false;
    }

    /**
     * @param $event
     *
     * @throws \InvalidArgumentException
     */
    public function checkEvent($event)
    {
        if (!in_array($event, self::$AVAILABLE_EVENTS)) {
            throw new \InvalidArgumentException(sprintf('Unsupported event: `%s`, available events: `%s`',
                    $event,
                    implode(', ', self::$AVAILABLE_EVENTS)
                )
            );
        }
    }
}
