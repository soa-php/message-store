<?php

declare(strict_types=1);

namespace Soa\MessageStore\Subscriber;

interface MessageSubscriber
{
    public function connect(): void;

    public function onConsume(): void;

    public function disconnect(): void;

    public function subscribeTo(string $exchange, array $routingKeys): void;
}
