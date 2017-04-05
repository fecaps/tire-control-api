<?php
declare(strict_types=1);

namespace Api\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;
use Api\Model\User;
use Api\Exception\ValidatorException;
use Exception;

class UserCreateCommand extends Command
{
    private $userModel;

    public function setModel(User $userModel)
    {
        $this->userModel = $userModel;
    }

    protected function configure()
    {
        $this
            ->setName('tire-control:create-user')
            ->setDescription('Create user')
            ->setHelp('This command allows you to create a user')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The user name'
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The user e-mail'
            )
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'The username'
            )
            ->addArgument(
                'passwd',
                InputArgument::REQUIRED,
                'The user password'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name       = $input->getArgument('name');
        $email      = $input->getArgument('email');
        $username   = $input->getArgument('username');
        $passwd     = $input->getArgument('passwd');

        $userData = [
            'name'      => $name,
            'email'     => $email,
            'username'  => $username,
            'passwd'    => $passwd
        ];

        try {
            $user = $this->userModel->create($userData);
        } catch (ValidatorException $exception) {
            throw new Exception($exception->getFullMessage());
        }

        $output->writeln([
            'User created:',
            'Name:     ' . $user['name'],
            'Email:    ' . $user['email'],
            'Username: ' . $user['username']
        ]);
    }
}
