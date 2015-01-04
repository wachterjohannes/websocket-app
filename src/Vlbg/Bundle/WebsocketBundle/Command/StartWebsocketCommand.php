<?php

namespace Vlbg\Bundle\WebsocketBundle\Command;

use Ratchet;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartWebsocketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('vlbg:start:websocket')
            ->addArgument('port', null, '', 9876);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument('port');

        $output->writeln('Connect to ws://localhost:' . $port);

        $app = new Ratchet\App('localhost', $port);
        $app->route('/ticker/{id}', $this->getContainer()->get('vlbg_websocket.websocket'), array('*'));
        $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
        $app->run();
    }
}
