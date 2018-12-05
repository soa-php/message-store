<?php

declare(strict_types=1);

namespace Soa\MessageStore\Publisher;

interface PublishedMessageTracker
{
    public function lastMessagePublishedBy(string $publisherName): int;

    public function trackLastMessagePublishedBy(int $offset, string $publisherName): void;
}
