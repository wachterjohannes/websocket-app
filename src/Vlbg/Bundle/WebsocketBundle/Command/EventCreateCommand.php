<?php

namespace Vlbg\Bundle\WebsocketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vlbg\Bundle\WebsocketBundle\Entity\Event;

class EventCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('vlbg:create:event')
            ->addArgument('name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = new Event();
        $entity->setName($input->getArgument('name'));

        $this->getContainer()->get('vlbg_websocket.ticker')->createEvent($entity);
    }
}
