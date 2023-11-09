<?php

namespace App\Service\ScheduleGenerator\Strategy;

/**
 * Алгоритм создания расписания
 */
class BaseScheduleGeneratorStrategy implements ScheduleGeneratorStrategyInterface
{
    /**
     * @param array $teams
     * @param int $gamesPerDay
     * @return array
     */
    public function generate(array $teams, int $gamesPerDay): array
    {
        $teamsCount = count($teams);
        $matchUp = [];
        $day = 1;
        $spliceCount = 0;
        $playedMatchCount = 0;

        $dailyLimit = function ($i) use ($teamsCount, $gamesPerDay) {
            return $i % min($teamsCount / 2, $gamesPerDay) === 0;
        };

        while ($spliceCount < $teamsCount - 1) {
            for ($i = 0; $i < $teamsCount / 2; $i++) {
                $dailyGames[$teams[$i]] = $teams[$teamsCount - 1 - $i];
                $playedMatchCount++;

                if ($dailyLimit($playedMatchCount)) {
                    $matchUp[$day] = $dailyGames;
                    $dailyGames = [];
                    $day++;
                }
            }

            //двигаем команды по схеме: крайняя команда перемещается на 2-ю позицию и сдвигает весь список вправо
            array_splice($teams, 1, 0, [array_pop($teams)]);
            $spliceCount++;
        }

        return $matchUp;
    }
}