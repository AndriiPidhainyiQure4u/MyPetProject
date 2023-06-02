<?php

declare(strict_types=1);

namespace Modules\Auth\Command\JoinByEmail\Request;

class Command
{
    public string $email = '';
    public string $password = '';
}
