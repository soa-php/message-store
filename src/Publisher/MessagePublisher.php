<?php

declare(strict_types=1);

namespace Soa\MessageStore\Publisher;

interface MessagePublisher
{
    public function connect(): void;

    public function name(): string;

    /**
     * @param StoredMessage[] $storedMessages
     */
    public function publishMessages(array $storedMessages): int;

    public function disconnect(): void;
}
