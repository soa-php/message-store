<?php

declare(strict_types=1);

namespace Soa\MessageStore\Subscriber\Error;

use Soa\MessageStore\Message;

interface ErrorMessageTimeoutTracker
{
    public function track(Message $message): void;

    public function trackedAt(Message $message): ?\DateTimeImmutable;

    public function untrack(Message $message): void;
}
