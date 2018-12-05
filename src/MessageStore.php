<?php

declare(strict_types=1);

namespace Soa\MessageStore;

interface MessageStore
{
    public function appendMessages(Message ...$messages): void;

    public function messagesSince(int $offset): array;
}
