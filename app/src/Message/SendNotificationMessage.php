<?php

declare(strict_types=1);

namespace App\Message;

final class SendNotificationMessage
{
    private string $text;

    public function __construct(string $text)
    {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
