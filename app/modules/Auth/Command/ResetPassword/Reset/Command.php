<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ResetPassword\Reset;

class Command
{
    public string $token = '';
    public string $password = '';
}
