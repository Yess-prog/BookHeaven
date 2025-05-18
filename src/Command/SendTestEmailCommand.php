<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:send-test-email',
    description: 'Sends a test email.',
)]
class SendTestEmailCommand extends Command
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (new Email())
            ->from('ssnaccache1@gmail.com')
            ->to('ssnaccache1@gmail.com') // Replace with your email
            ->subject('Test Email')
            ->text('This is a test email from Symfony.');

        $this->mailer->send($email);

        $output->writeln('✅ Email sent!');

        return Command::SUCCESS;
    }
}
