<?php

declare(strict_types=1);

namespace Soa\MessageStore\Publisher;

use Soa\MessageStore\Loop\LoopFactory;
use Soa\MessageStore\Subscriber\MessageSubscriber;
use Soa\MessageStore\Subscriber\Listener\MessageRouter;
use Psr\Log\LoggerInterface;

class PublisherApplication
{
    /**
     * @var MessageRouter
     */
    private $publisher;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MessageSubscriber
     */
    private $deliveryService;

    /**
     * @var LoopFactory
     */
    private $loopFactory;

    public function __construct(MessagePublisher $publisher, MessageDeliveryService $deliveryService, LoggerInterface $logger, LoopFactory $loopFactory)
    {
        $this->publisher       = $publisher;
        $this->deliveryService = $deliveryService;
        $this->logger          = $logger;
        $this->loopFactory     = $loopFactory;
    }

    public function startPublishing(): void
    {
        $this->publisher->connect();

        $loop = $this->loopFactory->create(
            0,
            function () {
                $publishedMessages = $this->deliveryService->publishMessagesThrough($this->publisher);

                if ($publishedMessages) {
                    $this->logger->info("Published $publishedMessages messages");
                }
            },
            function () {
                $this->publisher->disconnect();
            }
        );

        $loop->run();
    }
}
