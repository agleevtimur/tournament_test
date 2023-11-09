<?php

namespace App\Service\ScheduleGenerator;

use App\Service\OrderStrategy\OrderStrategyInterface;
use App\Service\ScheduleGenerator\Exception\DailyLimitException;
use App\Service\ScheduleGenerator\Exception\ScheduleGeneratorStrategyException;
use App\Service\ScheduleGenerator\Strategy\ScheduleGeneratorStrategyInterface;

/**
 * "Конструктур" генераторов расаписаний.
 * По-скольку содержит в себе логику и метод generate, настоящим конструктором не является.
 * ToDo отказаться от generate() в пользу createScheduleGenerator(). Сделать класс настоящим конструктором
 * ToDo отказаться от явных методов add...() в пользу динамического добавления параметров/правил для контструктора
 */
class ScheduleGeneratorManager
{
    private int $gamesPerDayLimit;
    private ?OrderStrategyInterface $teamsOrderStrategy;
    private string $extraTeamName;
    private ScheduleGeneratorStrategyInterface $scheduleGeneratorStrategy;

    public function addGamesPerDayLimit(int $limit): static
    {
        $this->gamesPerDayLimit = $limit;

        return $this;
    }

    public function addTeamsOrderStrategy(OrderStrategyInterface $orderStrategy): static
    {
        $this->teamsOrderStrategy = $orderStrategy;

        return $this;
    }

    public function addExtraTeamNameForOddCount(string $name): static
    {
        $this->extraTeamName = $name;

        return $this;
    }

    public function setScheduleGenerator(ScheduleGeneratorStrategyInterface $scheduleGeneratorStrategy): static
    {
        $this->scheduleGeneratorStrategy = $scheduleGeneratorStrategy;

        return $this;
    }

    public function generate(array $teams): array
    {
        $teams = array_map(fn($team) => $team->getName() ?? $team, $teams);

        if (count($teams) % 2 !== 0) {
            $teams[] = $this->extraTeamName ?? "";
        }

        if (isset($this->teamsOrderStrategy)) {
            $teams = $this->teamsOrderStrategy->order($teams);
        }

        if (!isset($this->scheduleGeneratorStrategy)) {
            throw new ScheduleGeneratorStrategyException();
        }

        if (!isset($this->gamesPerDayLimit)) {
            throw new DailyLimitException();
        }

        return $this->scheduleGeneratorStrategy->generate($teams, $this->gamesPerDayLimit);
    }
}