<?php

namespace App\Service\ScheduleGenerator\Strategy;

interface ScheduleGeneratorStrategyInterface
{
    /**
     * @param array $teams
     * @param int $gamesPerDay
     * @return array
     */
    public function generate(array $teams, int $gamesPerDay): array;
}