<?php

declare(strict_types=1);

namespace Soa\MessageStore;

class Message
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $occurredOn;

    /**
     * @var array
     */
    private $body;

    /**
     * @var string
     */
    private $streamId;

    /**
     * @var string
     */
    private $correlationId;

    /**
     * @var string
     */
    private $causationId;

    /**
     * @var string
     */
    private $replyTo;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $recipient;

    /**
     * @var string
     */
    private $processId;

    public function __construct(string $type, string $occurredOn, array $body, string $streamId, string $correlationId, string $causationId, string $replyTo, string $id, string $recipient, string $processId)
    {
        $this->type          = $type;
        $this->occurredOn    = $occurredOn;
        $this->body          = $body;
        $this->streamId      = $streamId;
        $this->correlationId = $correlationId;
        $this->causationId   = $causationId;
        $this->replyTo       = $replyTo;
        $this->id            = $id;
        $this->recipient     = $recipient;
        $this->processId     = $processId;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }

    public function body(): array
    {
        return $this->body;
    }

    public function streamId(): string
    {
        return $this->streamId;
    }

    public function correlationId(): string
    {
        return $this->correlationId;
    }

    public function causationId(): string
    {
        return $this->causationId;
    }

    public function replyTo(): string
    {
        return $this->replyTo;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function recipient(): string
    {
        return $this->recipient;
    }

    public function processId(): string
    {
        return $this->processId;
    }

    public function withType(string $type): self
    {
        $clone       = clone $this;
        $clone->type = $type;

        return $clone;
    }

    public function withOccurredOn(string $occurredOn): self
    {
        $clone             = clone $this;
        $clone->occurredOn = $occurredOn;

        return $clone;
    }

    public function withBody(array $body): self
    {
        $clone       = clone $this;
        $clone->body = $body;

        return $clone;
    }

    public function withStreamId(string $streamId): self
    {
        $clone           = clone $this;
        $clone->streamId = $streamId;

        return $clone;
    }

    public function withCorrelationId(string $correlationId): self
    {
        $clone                = clone $this;
        $clone->correlationId = $correlationId;

        return $clone;
    }

    public function withCausationId(string $causationId): self
    {
        $clone              = clone $this;
        $clone->causationId = $causationId;

        return $clone;
    }

    public function withReplyTo(string $replyTo): self
    {
        $clone          = clone $this;
        $clone->replyTo = $replyTo;

        return $clone;
    }

    public function withId(string $id): self
    {
        $clone     = clone $this;
        $clone->id = $id;

        return $clone;
    }

    public function withRecipient(string $recipient): self
    {
        $clone            = clone $this;
        $clone->recipient = $recipient;

        return $clone;
    }

    public function withProcessId(string $processId): self
    {
        $clone            = clone $this;
        $clone->processId = $processId;

        return $clone;
    }
}
