<?php

namespace Vlbg\Bundle\WebsocketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vlbg\Bundle\WebsocketBundle\Entity\Entry;

class EntryCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('vlbg:create:entity')
            ->addArgument('title')
            ->addArgument('creator')
            ->addArgument('message')
            ->addArgument('event');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();

        $entity = new Entry();
        $entity->setTitle($input->getArgument('title'));
        $entity->setMessage($input->getArgument('message'));
        $entity->setCreator($input->getArgument('creator'));
        $entity->setCreated(new \DateTime());
        $entity->setEvent($em->getReference('VlbgWebsocketBundle:Event', $input->getArgument('event')));

        $this->getContainer()->get('vlbg_websocket.ticker')->createEntry($entity);
    }
}
