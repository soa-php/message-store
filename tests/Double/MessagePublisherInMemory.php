<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Double;

use Soa\MessageStore\Message;
use Soa\MessageStore\Publisher\MessagePublisher;

class MessagePublisherInMemory implements MessagePublisher
{
    /**
     * @var Message[]
     */
    private $publishedMessages;

    /**
     * @var string
     */
    private $name;

    public static function withName(string $name): self
    {
        return new self($name);
    }

    public function __construct(string $name)
    {
        $this->publishedMessages = [];
        $this->name              = $name;
    }

    public function connect(): void
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function publishMessages(array $storedMessages): int
    {
        $this->publishedMessages = $storedMessages;

        return count($storedMessages);
    }

    public function disconnect(): void
    {
    }

    public function publishedMessages(): array
    {
        return $this->publishedMessages;
    }

    public function clean(): void
    {
        $this->publishedMessages = [];
    }
}
