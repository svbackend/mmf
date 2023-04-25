<?php

namespace App\Common\Service;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Use module specific mailer instead whenever possible, e.g App\User\Service\UserMailer
 * @internal
 */
class MailerService
{
    const FROM_EMAIL = 'noreply@mff.loc';
    const FROM_NAME = 'MyMiniFactory';
    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(
        MailerInterface $mailer,
        LoggerInterface $logger
    )
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    private function getDefaultFrom(): Address
    {
        return new Address(
            self::FROM_EMAIL,
            self::FROM_NAME,
        );
    }

    public function sendEmail(
        Address $to,
        string $subject,
        string $template,
        array $templateParams = []
    ): void
    {
        $email = (new TemplatedEmail())
            ->from($this->getDefaultFrom())
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($templateParams);

        try {
            $this->mailer->send($email);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
