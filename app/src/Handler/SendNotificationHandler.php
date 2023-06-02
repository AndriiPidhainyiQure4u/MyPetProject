<?php

declare(strict_types=1);

namespace App\Handler;

use App\Message\SendNotificationMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendNotificationHandler implements MessageHandlerInterface
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    public function __invoke(SendNotificationMessage $message)
    {
        sleep(5);

        echo 'hello';
    }
}
