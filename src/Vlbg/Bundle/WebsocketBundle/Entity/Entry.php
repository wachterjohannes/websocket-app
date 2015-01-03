<?php

namespace Vlbg\Bundle\WebsocketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entry
 */
class Entry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var string
     */
    private $creator;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Entry
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set creator
     *
     * @param string $creator
     * @return Entry
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return string 
     */
    public function getCreator()
    {
        return $this->creator;
    }
    /**
     * @var string
     */
    private $message;

    /**
     * @var \Vlbg\Bundle\WebsocketBundle\Entity\Event
     */
    private $event;


    /**
     * Set message
     *
     * @param string $message
     * @return Entry
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set event
     *
     * @param \Vlbg\Bundle\WebsocketBundle\Entity\Event $event
     * @return Entry
     */
    public function setEvent(\Vlbg\Bundle\WebsocketBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Vlbg\Bundle\WebsocketBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }
}
