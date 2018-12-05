<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Publisher;

use Soa\MessageStore\Publisher\MessageDeliveryService;
use Soa\MessageStoreTest\Double\MessagePublisherInMemory;
use Soa\MessageStoreTest\Double\MessageStoreInMemory;
use Soa\MessageStoreTest\Double\MessageDummy;
use Soa\MessageStoreTest\Double\PublishedMessageTrackerInMemory;
use PHPUnit\Framework\TestCase;

class MessageDeliveryServiceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldPublishAndTrackAllMessages()
    {
        $messages = [
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
        ];

        $messageStore     = MessageStoreInMemory::withMessages(...$messages);
        $tracker          = new PublishedMessageTrackerInMemory();
        $publisherName    = 'publisher name';
        $messagePublisher = MessagePublisherInMemory::withName($publisherName);

        $deliveryService   = new MessageDeliveryService($messageStore, $tracker);
        $publishedMessages = $deliveryService->publishMessagesThrough($messagePublisher);

        $this->assertEquals($messages, $messagePublisher->publishedMessages());
        $this->assertEquals([$publisherName => count($messages)], $tracker->track());
        $this->assertEquals($publishedMessages, count($messages));
    }

    /**
     * @test
     */
    public function shouldPublishAndTrackUnpublishedMessages()
    {
        $messages = [
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
        ];

        $alreadyTrackedMessages = array_slice($messages, 0, 3);
        $untrackedMessages      = array_slice($messages, 3);

        $publisherName    = 'publisher name';
        $messagePublisher = MessagePublisherInMemory::withName($publisherName);

        $currentTrack = [$publisherName => count($alreadyTrackedMessages)];
        $tracker      = PublishedMessageTrackerInMemory::withTrack($currentTrack);

        $messageStore = MessageStoreInMemory::withMessages(...$messages);

        $deliveryService   = new MessageDeliveryService($messageStore, $tracker);
        $publishedMessages = $deliveryService->publishMessagesThrough($messagePublisher);

        $this->assertEquals($untrackedMessages, $messagePublisher->publishedMessages());
        $this->assertEquals([$publisherName => count($alreadyTrackedMessages) + count($untrackedMessages)], $tracker->track());
        $this->assertEquals($publishedMessages, count($untrackedMessages));
    }

    /**
     * @test
     */
    public function shouldNotPublishAnyMessage()
    {
        $messages = [
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
            new MessageDummy(),
        ];

        $publisherName    = 'publisher name';
        $messagePublisher = MessagePublisherInMemory::withName($publisherName);

        $currentTrack = [$publisherName => count($messages)];
        $tracker      = PublishedMessageTrackerInMemory::withTrack($currentTrack);

        $messageStore = MessageStoreInMemory::withMessages(...$messages);

        $deliveryService   = new MessageDeliveryService($messageStore, $tracker);
        $publishedMessages = $deliveryService->publishMessagesThrough($messagePublisher);

        $this->assertEquals([], $messagePublisher->publishedMessages());
        $this->assertEquals([$publisherName => count($messages)], $tracker->track());
        $this->assertEquals($publishedMessages, 0);
    }
}
