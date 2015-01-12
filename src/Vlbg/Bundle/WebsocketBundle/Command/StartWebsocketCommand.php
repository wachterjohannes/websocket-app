<?php
/*
 * This file is part of the Sulu CMF.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vlbg\Bundle\WebsocketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StartWebsocketCommand
 */
class StartWebsocketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('vlbg:start:websocket');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = 9876;
        $output->writeln('Connect to ws://localhost:' . $port);

        $loop = \React\EventLoop\Factory::create();
        $messageComponent = $this->getContainer()->get('vlbg_websocket.component');

        $context = new \React\ZMQ\Context($loop);
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555');
        $pull->on('message', array($messageComponent, 'onEntryCreated'));

        $app = new \Ratchet\App('localhost', $port, '127.0.0.1', $loop);
        $app->route('/echo', new \Ratchet\Server\EchoServer());
        $app->route('/ticker/{id}', $messageComponent);
        $app->run();
    }
}
