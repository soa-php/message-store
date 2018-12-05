<?php

declare(strict_types=1);

namespace Soa\MessageStore\Publisher;

use Soa\MessageStore\MessageStore;

class MessageDeliveryService
{
    /**
     * @var MessageStore
     */
    private $store;

    /**
     * @var PublishedMessageTracker
     */
    private $tracker;

    public function __construct(MessageStore $store, PublishedMessageTracker $tracker)
    {
        $this->store   = $store;
        $this->tracker = $tracker;
    }

    public function publishMessagesThrough(MessagePublisher $messagePublisher): int
    {
        $offset                = $this->tracker->lastMessagePublishedBy($messagePublisher->name());
        $nextMessagesToDeliver = $this->store->messagesSince($offset);

        if (!$nextMessagesToDeliver) {
            return 0;
        }

        $numMessagesDelivered = $messagePublisher->publishMessages($nextMessagesToDeliver);

        $this->tracker->trackLastMessagePublishedBy($offset + $numMessagesDelivered, $messagePublisher->name());

        return $numMessagesDelivered;
    }
}
