<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppCreateClientCommand extends Command {

    protected function configure() {
        $this->setName('app:create-client')
                ->setDescription('Create a new client')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $clientManager = $this->getApplication()->getKernel()->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array(''));
        $client->setAllowedGrantTypes(array('password'));
        $clientManager->updateClient($client);
        
        $output->writeln('Client successfully generated!');
    }

}
        