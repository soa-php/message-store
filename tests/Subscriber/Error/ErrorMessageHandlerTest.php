<?php

declare(strict_types=1);

namespace Soa\MessageStoreTest\Subscriber\Error;

use PHPUnit\Framework\TestCase;
use Soa\Clock\ClockFake;
use Soa\MessageStoreTest\Double\ErrorMessageHandlerSpy;
use Soa\MessageStoreTest\Double\ErrorMessageTimeoutTrackerStub;
use Soa\MessageStoreTest\Double\MessageDummy;

class ErrorMessageHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldRequeueMessage()
    {
        $trackedTimestamp    = new \DateTimeImmutable('2019-01-01 00:00:00');
        $errorMessageTracker = ErrorMessageTimeoutTrackerStub::withTrackedAt($trackedTimestamp);
        $errorHandler        = new ErrorMessageHandlerSpy(
            $errorMessageTracker,
                new ClockFake('2019-01-01 00:00:01.358'),
                5
            );

        $message = (new MessageDummy())->withId('some id');
        $errorHandler->handleMessage($message);

        $this->assertTrue($errorHandler->messageRequeued());
        $this->assertFalse($errorHandler->messageDeadLettered());
        $this->assertEquals([$message->id() => $trackedTimestamp], $errorMessageTracker->trackedMessages());
    }

    /**
     * @test
     */
    public function shouldDeadLetterMessage()
    {
        $trackedTimestamp    = new \DateTimeImmutable('2019-01-01 00:00:00');
        $errorMessageTracker = ErrorMessageTimeoutTrackerStub::withTrackedAt($trackedTimestamp);
        $errorHandler        = new ErrorMessageHandlerSpy(
            $errorMessageTracker,
            new ClockFake('2019-01-01 00:00:06.358'),
            5
        );

        $message = (new MessageDummy())->withId('some id');
        $errorHandler->handleMessage($message);

        $this->assertFalse($errorHandler->messageRequeued());
        $this->assertTrue($errorHandler->messageDeadLettered());
        $this->assertEquals([], $errorMessageTracker->trackedMessages());
    }
}
