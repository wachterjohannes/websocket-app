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

        $app = new \Ratchet\App('localhost', $port);
        $app->route('/echo', new \Ratchet\Server\EchoServer());
        $app->run();
    }
}
