<?php

declare(strict_types=1);

namespace Soa\MessageStore\Loop\Pcntl;

use Soa\MessageStore\Loop\LoopInterface;
use React\EventLoop\LoopInterface as PcntlLoopInterface;

class PcntlLoop implements LoopInterface
{
    /**
     * @var PcntlLoopInterface
     */
    private $loop;

    public function __construct(PcntlLoopInterface $loop)
    {
        $this->loop = $loop;
    }

    public function run(): void
    {
        $this->loop->run();
    }
}
