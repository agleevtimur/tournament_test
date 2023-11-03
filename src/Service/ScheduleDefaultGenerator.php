<?php

namespace App\Service;

use App\Entity\Team;

class ScheduleDefaultGenerator implements ScheduleGeneratorInterface
{
    private static int $maxGamesPerDay = 4;

    /**
     * @param Team[] $teams
     * @return array
     */
    public function generate(array $teams): array
    {
        $teamsCount = count($teams);
        $matchUp = [];
        $day = 1;
        $spliceCount = 0;
        $playedMatchCount = 0;

        $dailyLimit = function ($i) use ($teamsCount) {
            return $i % min($teamsCount / 2, self::$maxGamesPerDay) === 0;
        };

        while (true) {
            for ($i = 0; $i < $teamsCount / 2; $i++) {
                $dailyGames[] = "{$teams[$i]->getName()} : {$teams[$teamsCount - 1 - $i]->getName()}";
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
            if ($spliceCount === $teamsCount - 1) {
                break;
            }
        }

        return $matchUp;
    }
}