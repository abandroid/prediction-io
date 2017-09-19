<?php

namespace Endroid\PredictionIO\Model;

/**
 * Class AbstractEvent.
 */
abstract class AbstractEvent
{
    const EVENT_TYPE_ENTITY = 'entity';
    const EVENT_TYPE_CUSTOM = 'custom';

    /**
     * @var string
     */
    protected $event;
    /**
     * @var string
     */
    protected $entityType;
    /**
     * @var string
     */
    protected $entityId;
    /**
     * @var string
     */
    protected $targetEntityType = null;
    /**
     * @var string
     */
    protected $targetEntityId = null;
    /**
     * @var array
     */
    protected $properties = [];
    /**
     * @var \DateTime
     */
    protected $eventTime = null;
    /**
     * @var string
     */
    protected $_eventType;

    /**
     * AbstractEvent constructor.
     *
     * @param string $event
     * @param string $entityType
     * @param string $entityId
     */
    public function __construct($event, $entityType, $entityId)
    {
        $this->event = $event;
        $this->entityType = $entityType;
        $this->entityId = $entityId;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param $event
     *
     * @return $this
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param $entityType
     *
     * @return $this
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param $entityId
     *
     * @return $this
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetEntityType()
    {
        return $this->targetEntityType;
    }

    /**
     * @param $targetEntityType
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function setTargetEntityType($targetEntityType)
    {
        if (!$this->supportsTargetEntity()) {
            throw new \InvalidArgumentException(sprintf('Event of type `%s` does not support setting a target entity',
                    $this->getEventType()
                )
            );
        }
        $this->targetEntityType = $targetEntityType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetEntityId()
    {
        return $this->targetEntityId;
    }

    /**
     * @param $targetEntityId
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function setTargetEntityId($targetEntityId)
    {
        if (!$this->supportsTargetEntity()) {
            throw new \InvalidArgumentException(sprintf('Event of type `%s` does not support setting a target entity',
                    $this->getEventType()
                )
            );
        }
        $this->targetEntityId = $targetEntityId;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     *
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @param bool $formatted Returns event time in ISO-8601 format
     *
     * @return \DateTime
     */
    public function getEventTime($formatted = true)
    {
        if ($formatted && $this->eventTime instanceof \DateTime) {
            return $this->eventTime->format('c');
        }

        return $this->eventTime;
    }

    /**
     * @param $eventTime
     *
     * @return $this
     */
    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventType()
    {
        return $this->_eventType;
    }

    /**
     * @param $eventType
     *
     * @return $this
     */
    public function setEventType($eventType)
    {
        $this->_eventType = $eventType;

        return $this;
    }

    /**
     * @return bool
     */
    abstract public function supportsTargetEntity();

    /**
     * @return bool
     */
    public function isEntityEvent()
    {
        return self::EVENT_TYPE_ENTITY == $this->getEventType();
    }

    /**
     * @return bool
     */
    public function isCustomEvent()
    {
        return self::EVENT_TYPE_CUSTOM == $this->getEventType();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $arrarizedEvent = [];
        $arrarizedEvent['event'] = $this->getEvent();
        $arrarizedEvent['entityType'] = $this->getEntityType();
        $arrarizedEvent['entityId'] = $this->getEntityId();
        if ($this->supportsTargetEntity()) {
            if ($targetEntityType = $this->getTargetEntityType()) {
                $arrarizedEvent['targetEntityType'] = $targetEntityType;
            }
            if ($targetEntityId = $this->getTargetEntityId()) {
                $arrarizedEvent['targetEntityId'] = $targetEntityId;
            }
        }
        $properties = $this->getProperties();
        if (!empty($properties)) {
            $arrarizedEvent['properties'] = $properties;
        }
        if ($eventTime = $this->getEventTime()) {
            $arrarizedEvent['eventTime'] = $eventTime;
        }

        return $arrarizedEvent;
    }
}
