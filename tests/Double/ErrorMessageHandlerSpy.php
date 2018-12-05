<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Double;

use Soa\MessageStore\Message;
use Soa\MessageStore\Subscriber\Error\ErrorMessageHandler;

class ErrorMessageHandlerSpy extends ErrorMessageHandler
{
    /**
     * @var bool
     */
    private $messageRequeued = false;

    /**
     * @var bool
     */
    private $messageDeadLettered = false;

    protected function requeueMessage(Message $message): void
    {
        $this->messageRequeued = true;
    }

    protected function deadLetterMessage(Message $message): void
    {
        $this->messageDeadLettered = true;
    }

    public function messageRequeued(): bool
    {
        return $this->messageRequeued;
    }

    public function messageDeadLettered(): bool
    {
        return $this->messageDeadLettered;
    }
}
