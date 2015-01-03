<?php

namespace Vlbg\Bundle\WebsocketBundle\Ticker;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class TickerMessageComponent implements MessageComponentInterface
{
    /**
     * @var TickerManager
     */
    private $manager;

    function __construct($manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    function onOpen(ConnectionInterface $conn)
    {
    }

    /**
     * {@inheritdoc}
     */
    function onClose(ConnectionInterface $conn)
    {
    }

    /**
     * {@inheritdoc}
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
    }

    /**
     * {@inheritdoc}
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
    }
}
