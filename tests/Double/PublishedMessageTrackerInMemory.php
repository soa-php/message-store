<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Double;

use Soa\MessageStore\Publisher\PublishedMessageTracker;

class PublishedMessageTrackerInMemory implements PublishedMessageTracker
{
    /**
     * @var array
     */
    private $track;

    public static function withTrack(array $track): self
    {
        return new self($track);
    }

    public function __construct(array $track = [])
    {
        $this->track = $track;
    }

    public function lastMessagePublishedBy(string $publisherName): int
    {
        return $this->track[$publisherName] ?? 0;
    }

    public function trackLastMessagePublishedBy(int $offset, string $publisherName): void
    {
        $this->track[$publisherName] = $offset;
    }

    public function track(): array
    {
        return $this->track;
    }
}
