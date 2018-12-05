<?php

declare(strict_types=1);

namespace Soa\MessageStore\Subscriber;

use Soa\MessageStore\Loop\LoopFactory;
use Soa\MessageStore\Subscriber\Listener\MessageRouter;

class SubscriberApplication
{
    /**
     * @var MessageRouter
     */
    private $router;

    /**
     * @var MessageSubscriber
     */
    private $subscriber;

    /**
     * @var LoopFactory
     */
    private $loopFactory;

    public function __construct(MessageRouter $router, MessageSubscriber $subscriber, LoopFactory $loopFactory)
    {
        $this->router      = $router;
        $this->subscriber  = $subscriber;
        $this->loopFactory = $loopFactory;
    }

    public function addSubscription(string $topic, string $messageType, string $listener): void
    {
        $this->router->add($topic, $messageType, $listener);
    }

    public function startConsuming(): void
    {
        $this->subscriber->connect();

        foreach ($this->router->routes() as $producerName => $messagesOfInterest) {
            $this->subscriber->subscribeTo($producerName, array_keys($messagesOfInterest));
        }

        $loop = $this->loopFactory->create(
            0,
            function () {
                $this->subscriber->onConsume();
            }, function () {
                $this->subscriber->disconnect();
            }
        );

        $loop->run();
    }
}
