<?php

namespace App\Service\OrderStrategy;

/**
 * Алгоритм упорядочивания команд для создания расписаний
 */
class OrderShuffleStrategy implements OrderStrategyInterface
{

    public function order(array $teams): array
    {
        shuffle($teams);

        return $teams;
    }
}