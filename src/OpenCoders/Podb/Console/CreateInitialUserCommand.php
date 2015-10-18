<?php

namespace OpenCoders\Podb\Console;


use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Knp\Command\Command;
use OpenCoders\Podb\Persistence\Entity\User;
use OpenCoders\Podb\Security\PasswordSaltGenerator;
use OpenCoders\Podb\Security\SecurityServices;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class CreateInitialUserCommand extends Command
{
    const INITIAL_USER_PASSWORD = 'admin';

    const INITIAL_USER_NAME = 'admin';
    /**
     * @var PasswordSaltGenerator
     */
    private $passwordSaltGenerator;

    /**
     * @var MessageDigestPasswordEncoder
     */
    private $passwordEncoder;

    public function __construct()
    {
        parent::__construct('init:main:user');
        $this->setDescription('Initialize the main system user.');
        $this->setHelp(<<<EOT
The <info>%command.name%</info> create basic user.
EOT
        );
        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Reset inital user if exists.');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $silexApp = $this->getSilexApplication();
        $this->passwordSaltGenerator = $silexApp[SecurityServices::SALT_GENERATOR];
        $this->passwordEncoder = $silexApp['security.encoder.digest'];
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManagerHelper $helper */
        $helper = $this->getHelper('em');
        $entityManager = $helper->getEntityManager();

        $userRepository = $entityManager->getRepository(User::ENTITY_NAME);

        $user = $userRepository->find(1);
        if ($user instanceof User && !$input->getOption('force')) {
            $output->writeln('Initial user already created');
            return;
        }

        $created = false;
        if (!$user instanceof User) {
            $user = new User();
            $created = true;
        }
        $user->setUsername(self::INITIAL_USER_NAME);
        $user->setDisplayName('Admin');
        $user->setActive(true);
        $user->setEmailValidated(true);
        $user->setValidated(true);
        $user->setEmail('admin@localhost');

        try {
            $salt = $this->passwordSaltGenerator->generate();
            $user->setSalt($salt);
            $password = $this->passwordEncoder->encodePassword(self::INITIAL_USER_PASSWORD, $salt);
            $user->setPassword($password);
        } catch (\Exception $e) {
            $output->writeln('Can´t generate password');
            $output->writeln($e->getMessage());
            return;
        }

        $entityManager->persist($user);
        $entityManager->flush();

        if ($created) {
            $output->writeln('Initial user created');
        } else {
            $output->writeln('Initial user reset');
        }
        $output->writeln('--------------------');
        $output->writeln('Username: ' . self::INITIAL_USER_NAME);
        $output->writeln('Password: ' . self::INITIAL_USER_PASSWORD);
        $output->writeln('--------------------');
    }

}
