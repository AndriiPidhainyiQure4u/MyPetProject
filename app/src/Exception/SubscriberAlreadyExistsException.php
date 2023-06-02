<?php

declare(strict_types=1);

namespace App\Exception;

final class SubscriberAlreadyExistsException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Subscriber already exists');
    }
}
