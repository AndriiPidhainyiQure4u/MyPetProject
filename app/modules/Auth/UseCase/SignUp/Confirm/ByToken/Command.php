<?php

declare(strict_types=1);


namespace Modules\Auth\UseCase\SignUp\Confirm\ByToken;

class Command
{
    public function __construct(public string $token)
    {
    }
}
