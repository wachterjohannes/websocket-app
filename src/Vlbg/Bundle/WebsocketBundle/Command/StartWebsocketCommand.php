<?php

namespace Vlbg\Bundle\WebsocketBundle\Command;

use Ratchet\Server\IoServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vlbg\Bundle\WebsocketBundle\Entity\Entry;

class StartWebsocketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('vlbg:start:websocket')
            ->addArgument('port', null, '', 9876);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
            $this->getContainer()->get('vlbg_websocket.websocket'),
            $input->getArgument('port')
        );

        $server->run();
    }
}
