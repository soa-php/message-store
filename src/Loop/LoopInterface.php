<?php

declare(strict_types=1);

namespace Soa\MessageStore\Loop;

interface LoopInterface
{
    public function run(): void;
}
