<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Double;

use Soa\MessageStore\Message;
use Soa\MessageStore\MessageStore;

class MessageStoreInMemory implements MessageStore
{
    /**
     * @var Message[]
     */
    private $messages;

    public static function withMessages(Message ...$messages): self
    {
        return new self($messages);
    }

    private function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    public function appendMessages(Message ...$messages): void
    {
        $this->messages[] = $messages;
    }

    public function messagesSince(int $offset): array
    {
        return array_slice($this->messages, $offset);
    }
}
