<?php

namespace Endroid\PredictionIO\Model;

/**
 * Class CustomEvent.
 */
class CustomEvent extends AbstractEvent
{
    /**
     * @param string $event
     * @param string $entityType
     * @param string $entityId
     */
    public function __construct($event, $entityType, $entityId)
    {
        parent::__construct($event, $entityType, $entityId);
        $this->setEventType(self::EVENT_TYPE_CUSTOM);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTargetEntity()
    {
        return true;
    }
}
