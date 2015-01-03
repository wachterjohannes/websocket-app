<?php

namespace Vlbg\Bundle\WebsocketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function tickerAction($id, Request $request)
    {
        $manager = $this->get('vlbg_websocket.ticker');

        $since = $request->get('since');
        if ($since !== null) {
            $since = \DateTime::createFromFormat('Y-m-d H:i:s', $since);
        }
        $event = $manager->getEvent($id);
        $entries = $manager->getEntries($id, $since);

        if ($request->getRequestFormat() === 'json') {
            return $this->render(
                'VlbgWebsocketBundle:Dashboard:ticker.json.twig',
                array(
                    'event' => $event,
                    'entries' => iterator_to_array($entries)
                )
            );
        } else {
            return $this->render(
                'VlbgWebsocketBundle:Dashboard:ticker.html.twig',
                array(
                    'event' => $event,
                    'entries' => $entries
                )
            );
        }
    }
}
