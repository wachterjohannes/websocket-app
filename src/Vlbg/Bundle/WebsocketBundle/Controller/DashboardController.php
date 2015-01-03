<?php

namespace Vlbg\Bundle\WebsocketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $doctrine = $this->get('doctrine');
        $eventRepository = $doctrine->getRepository('VlbgWebsocketBundle:Event');

        return $this->render(
            'VlbgWebsocketBundle:Dashboard:index.html.twig',
            array('events' => $eventRepository->findAll())
        );
    }

    public function tickerAction($id)
    {
        $doctrine = $this->get('doctrine');
        $eventRepository = $doctrine->getRepository('VlbgWebsocketBundle:Event');
        $entryRepository = $doctrine->getRepository('VlbgWebsocketBundle:Entry');

        return $this->render(
            'VlbgWebsocketBundle:Dashboard:ticker.html.twig',
            array(
                'event' => $eventRepository->find($id),
                'entries' => $entryRepository->findBy(array('event' => $id), array('created' => 'DESC'))
            )
        );
    }
}
