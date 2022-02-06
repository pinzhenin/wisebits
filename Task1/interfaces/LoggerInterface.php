<?php

namespace interfaces;

interface LoggerInterface
{
    /**
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info(string $message, array $context): void;
}
