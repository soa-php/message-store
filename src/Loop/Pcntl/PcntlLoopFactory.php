<?php

declare(strict_types=1);

namespace Soa\MessageStore\Loop\Pcntl;

use React\EventLoop\Factory as EventLoopFactory;
use Soa\MessageStore\Loop\LoopFactory;
use Soa\MessageStore\Loop\LoopInterface;

class PcntlLoopFactory implements LoopFactory
{
    public function create(int $secondsInterval, callable $runFunction, callable $stopFunction): LoopInterface
    {
        $loop  = EventLoopFactory::create();
        $timer = $loop->addPeriodicTimer($secondsInterval, function () use ($runFunction) {
            $runFunction();
            pcntl_signal_dispatch();
        });

        $handler = function ($signal) use ($loop, $timer, $stopFunction) {
            $loop->cancelTimer($timer);
            $stopFunction($signal);
        };

        pcntl_signal(SIGHUP, $handler);
        pcntl_signal(SIGTERM, $handler);
        pcntl_signal(SIGINT, $handler);
        pcntl_signal(SIGCONT, $handler);

        return new PcntlLoop($loop);
    }
}
