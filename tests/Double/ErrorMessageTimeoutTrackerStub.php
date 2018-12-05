<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Double;

use Soa\MessageStore\Message;
use Soa\MessageStore\Subscriber\Error\ErrorMessageTimeoutTracker;

class ErrorMessageTimeoutTrackerStub implements ErrorMessageTimeoutTracker
{
    /**
     * @var \DateTimeImmutable
     */
    private $trackedAt;

    /**
     * @var Message[]
     */
    private $trackedMessages = [];

    public static function withTrackedAt(\DateTimeImmutable $dateTimeImmutable): self
    {
        return new self($dateTimeImmutable);
    }

    private function __construct(\DateTimeImmutable $trackedAt)
    {
        $this->trackedAt = $trackedAt;
    }

    public function track(Message $message): void
    {
        $this->trackedMessages[$message->id()] = $this->trackedAt;
    }

    public function trackedAt(Message $message): \DateTimeImmutable
    {
        return $this->trackedMessages[$message->id()];
    }

    public function untrack(Message $message): void
    {
        unset($this->trackedMessages[$message->id()]);
    }

    public function trackedMessages(): array
    {
        return $this->trackedMessages;
    }
}
