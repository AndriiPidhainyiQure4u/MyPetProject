<?php

declare(strict_types=1);

namespace Modules\Auth\Service;

use Modules\Auth\Entity\User\Email;
use Modules\Auth\Entity\User\Token;

interface JoinConfirmationSender
{
    public function send(Email $email, Token $token): void;
}
