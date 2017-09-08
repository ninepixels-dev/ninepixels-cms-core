<?php

namespace AppBundle\Command;

use AppBundle\Entity\Page;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppInitializeCommand extends Command {

    protected function configure() {
        $this->setName('app:initialize')
                ->setDescription('Set default data for application');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('Updating database...');
        $command = $this->getApplication()->find('doctrine:schema:update');

        $greetInput = new ArrayInput(array('--force' => true));
        $command->run($greetInput, $output);

        $output->writeln('Database succesfully updated!');
        $output->writeln('Creating client...');

        $clientManager = $this->getApplication()->getKernel()->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array(''));
        $client->setAllowedGrantTypes(array('password'));
        $clientManager->updateClient($client);

        $output->writeln('Client succesfully created!');
        $output->writeln('Creating user...');

        $userManager = $this->getApplication()->getKernel()->getContainer()->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setName('Admin Adminovic');
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMIN');
        $userManager->updateUser($user);

        $output->writeln('User succesfully created!');
        $output->writeln('Creating homepage...');

        $pageManager = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();
        $homepage = new Page();
        $homepage->setUser($user);
        $homepage->setName('homepage');
        $homepage->setTemplate('homepage.php');

        $pageManager->persist($homepage);
        $pageManager->flush();

        $output->writeln('Homepage created!');
        $output->writeln('You\'r done! Ready to go! :)');
    }

}
