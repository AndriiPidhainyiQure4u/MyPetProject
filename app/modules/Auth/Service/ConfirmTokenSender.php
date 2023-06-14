<?php

declare(strict_types=1);

namespace Modules\Auth\Service;

use Modules\Auth\Entity\User\Email;
use Twig;

class ConfirmTokenSender
{
    public function __construct(private readonly \Swift_Mailer $mailer, private readonly Twig\Environment $twig)
    {
    }

    /**
     * @throws Twig\Error\RuntimeError
     * @throws Twig\Error\SyntaxError
     * @throws Twig\Error\LoaderError
     */
    public function send(Email $email, string $token): void
    {
        $message = (new \Swift_Message('Sig Up Confirmation'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/signup.html.twig', [
                'token' => $token,
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
