<?php
/*
 * This file is part of the Sulu CMF.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vlbg\Bundle\WebsocketBundle\Ticker;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Class TickerMessageComponent
 */
class TickerMessageComponent implements MessageComponentInterface
{

    /**
     * @var \SplObjectStorage
     */
    private $clients;

    function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onEntryCreated($entry)
    {
        $entryData = json_decode($entry, true);

        $this->sendMessage($entry, $entryData['event']);
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $query = $conn->WebSocket->request->getUrl(true)->getQuery();

        $this->clients->attach($conn, $query);
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->clients->detach($conn);
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $ticker = $this->clients[$from]['id'];

        $this->sendMessage($msg, $ticker);
    }

    protected function sendMessage($msg, $ticker)
    {
        foreach($this->clients as $client){
            if($this->clients[$client]['id'] == $ticker) {
                $client->send($msg);
            }
        }
    }
}
