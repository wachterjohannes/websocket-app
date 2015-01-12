<?php

namespace Vlbg\Bundle\WebsocketBundle\Command;

use Ratchet;
use React;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZMQ;

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

        $loop = React\EventLoop\Factory::create();
        $messageComponent = $this->getContainer()->get('vlbg_websocket.websocket');

        $context = new React\ZMQ\Context($loop);
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555');
        $pull->on('message', array($messageComponent, 'onEntryCreated'));

        $app = new Ratchet\App('localhost', $port, '127.0.0.1', $loop);
        $app->route('/ticker/{id}', $messageComponent, array('*'));
        $app->route('/echo', new Ratchet\Server\EchoServer, array('*'));
        $app->run();
    }
}
