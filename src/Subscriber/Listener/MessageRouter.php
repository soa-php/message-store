<?php

declare(strict_types=1);

namespace Soa\MessageStore\Subscriber\Listener;

use Soa\MessageStore\Message;
use Psr\Container\ContainerInterface;

class MessageRouter
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function add(string $topic, string $messageType, string $listener)
    {
        $this->routes[$topic][$messageType] = $listener;
    }

    public function dispatch(Message $message): void
    {
        $listener = $this->routes[$message->recipient()][$message->type()];

        /** @var MessageListener $listener */
        $listener = $this->container->get($listener);

        $listener->handle($message);
    }

    public function routes(): array
    {
        return $this->routes;
    }
}
