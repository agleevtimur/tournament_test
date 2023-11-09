<?php

namespace App\Service\OrderStrategy;

interface OrderStrategyInterface
{
    public function order(array $teams): array;
}