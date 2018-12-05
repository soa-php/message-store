<?php

declare(strict_types=1);

namespace Soa\MessageStore\Subscriber\Error;

use Soa\Clock\Clock;
use Soa\MessageStore\Message;

abstract class ErrorMessageHandler
{
    /**
     * @var ErrorMessageTimeoutTracker
     */
    private $tracker;

    /**
     * @var Clock
     */
    private $clock;

    /**
     * @var int
     */
    private $secondsToDeadLetter;

    public function __construct(ErrorMessageTimeoutTracker $tracker, Clock $clock, int $secondsToDeadLetter)
    {
        $this->tracker             = $tracker;
        $this->clock               = $clock;
        $this->secondsToDeadLetter = $secondsToDeadLetter;
    }

    public function handleMessage(Message $message): void
    {
        $this->tracker->track($message);

        $nowTime             = $this->clock->now();
        $firstAttemptTime    = $this->tracker->trackedAt($message);
        $differenceInSeconds = $nowTime->diff($firstAttemptTime)->s;

        if ($differenceInSeconds > $this->secondsToDeadLetter) {
            $this->deadLetterMessage($message);
            $this->tracker->untrack($message);
        } else {
            $this->requeueMessage($message);
        }
    }

    abstract protected function requeueMessage(Message $message): void;

    abstract protected function deadLetterMessage(Message $message): void;
}
