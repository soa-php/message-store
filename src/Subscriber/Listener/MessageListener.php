<?php

declare(strict_types=1);

namespace Soa\MessageStore\Subscriber\Listener;

use Soa\MessageStore\Message;

interface MessageListener
{
    public function handle(Message $message): void;
}
