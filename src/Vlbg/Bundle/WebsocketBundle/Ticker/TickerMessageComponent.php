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

    /**
     * @var \SplObjectStorage
     */
    private $clients;

    function __construct($manager)
    {
        $this->clients = new \SplObjectStorage();

        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    function onOpen(ConnectionInterface $conn)
    {
        $query = $conn->WebSocket->request->getUrl(true)->getQuery();

        $this->clients->attach($conn, $query);
    }

    /**
     * {@inheritdoc}
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * {@inheritdoc}
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    /**
     * {@inheritdoc}
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $ticker = $this->clients[$from]['id'];

        foreach ($this->clients as $client) {
            if ($this->clients[$client]['id'] === $ticker) {
                $client->send($msg);
            }
        }
    }
}
