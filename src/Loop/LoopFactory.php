<?php

declare(strict_types=1);

namespace Soa\MessageStore\Loop;

interface LoopFactory
{
    public function create(int $secondsInterval, callable $runFunction, callable $stopFunction): LoopInterface;
}
