<?php

namespace Vlbg\Bundle\WebsocketBundle\Ticker;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Vlbg\Bundle\WebsocketBundle\Entity\Entry;
use Vlbg\Bundle\WebsocketBundle\Entity\Event;

class TickerManager
{
    /**
     * @var EntityRepository
     */
    private $eventRepository;

    /**
     * @var EntityRepository
     */
    private $entryRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    function __construct(EntityManager $entityManager, EntityRepository $eventRepository, EntityRepository $entryRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->entryRepository = $entryRepository;
        $this->entityManager = $entityManager;
    }

    public function getEvents()
    {
        return $this->eventRepository->findAll();
    }

    public function getEvent($id)
    {
        return $this->eventRepository->find($id);
    }

    public function getEntries($id, $since = null)
    {
        $event = $this->getEvent($id);

        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->eq('event', $event));
        $criteria->orderBy(array('created' => 'DESC'));

        if ($since !== null) {
            $criteria->andWhere($criteria->expr()->gte('created', $since));
        }

        return $this->entryRepository->matching($criteria);
    }

    public function createEntry(Entry $entry)
    {
        $this->entityManager->persist($entry);
        $this->entityManager->flush();

        try{
            $context = new \ZMQContext();
            $socket = $context->getSocket(\ZMQ::SOCKET_PUSH);
            $socket->connect('tcp://localhost:5555');

            $socket->send(json_encode($entry));
        }catch(\ZMQSocketException $e){}
    }

    public function createEvent(Event $event)
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush();
    }
}
