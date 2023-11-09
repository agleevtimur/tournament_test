<?php

namespace App\Service\ScheduleGenerator;

use App\Service\OrderStrategy\OrderShuffleStrategy;
use App\Service\ScheduleGenerator\Strategy\BaseScheduleGeneratorStrategy;

/**
 * Готовый генератор расписания, собранный из конструктура
 */
class DefaultScheduleGenerator
{
    private static int $dailyLimit = 4;
    private static string $extraTeamName = 'отдых';
    public function __construct(private ScheduleGeneratorManager $scheduleGeneratorManager) {}

    public function generate(array $teams): array
    {
        return $this->scheduleGeneratorManager
            ->addGamesPerDayLimit(static::$dailyLimit)
            ->addTeamsOrderStrategy(new OrderShuffleStrategy())
            ->addExtraTeamNameForOddCount(static::$extraTeamName)
            ->setScheduleGenerator(new BaseScheduleGeneratorStrategy())
            ->generate($teams);
    }
}