<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
/*
#[AsCommand(
    name: 'app:create-admin',
    description: 'Add a short description for your command'
)]*/
class CreateAdminCommand extends Command
{


    protected static $defaultName = 'app:create-admin';
    protected static $defaultDescription = 'create admin account.';


    public function __construct(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'nom')
            ->addArgument('arg2', InputArgument::OPTIONAL, 'prénom')
            ->addArgument('arg3', InputArgument::OPTIONAL, 'email')
            ->addArgument('arg4', InputArgument::OPTIONAL, 'mot de passe');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $arg2 = $input->getArgument('arg2');
        $arg3 = $input->getArgument('arg3');
        $arg4 = $input->getArgument('arg4');

        $user = new User();
        $user->setFirstname($arg1);
        $user->setLastname($arg2);
        $user->setEmail($arg3);
        $user->setEmail($arg3);
        $user->setPassword($this->passwordHasher->hashPassword($user, $arg4));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setIsActif(1);
        $user->setIsVerified(1);
        $user->setLocked(0);
        $this->em->persist($user);
        $this->em->flush();

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s , %s , %s , %s', $arg1, $arg2, $arg3, $arg4));
        }

        $io->success('Admin created with success');

        return Command::SUCCESS;
    }
}
