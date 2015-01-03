<?php

namespace Vlbg\Bundle\WebsocketBundle\Ticker;


use Doctrine\ORM\EntityRepository;

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

    function __construct(EntityRepository $eventRepository, EntityRepository $entryRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->entryRepository = $entryRepository;
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
}
