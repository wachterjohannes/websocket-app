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
            $time = intval($since);
            $since = new \DateTime();
            $since->setTimestamp($time);
        }
        $event = $manager->getEvent($id);
        $entries = $manager->getEntries($id, $since);

        if ($request->getRequestFormat() === 'json') {
            $i = 0;
            $entries = iterator_to_array($entries);
            while (count($entries) === 0 && $i < 15) {
                usleep(1000000);
                $entries = $manager->getEntries($id, $since);
                $i++;
            }

            return $this->render(
                'VlbgWebsocketBundle:Dashboard:ticker.json.twig',
                array(
                    'event' => $event,
                    'entries' => $entries
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
