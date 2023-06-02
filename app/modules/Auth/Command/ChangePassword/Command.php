<?php

declare(strict_types=1);

namespace Modules\Auth\Command\ChangePassword;

class Command
{
    public string $id = '';
    public string $current = '';
    public string $new = '';
}
