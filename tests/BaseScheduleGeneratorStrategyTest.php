<?php

namespace App\Tests;

use App\Entity\Team;
use App\Service\ScheduleGenerator\ScheduleGeneratorManager;
use App\Service\ScheduleGenerator\Strategy\BaseScheduleGeneratorStrategy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BaseScheduleGeneratorStrategyTest extends TestCase
{
    #[DataProvider('teamsProvider')]
    public function testGenerate(int $dailyLimit, array $data, array $expected)
    {
        $teams = array_map(fn($name) => (new Team())->setName($name), $data);
        $scheduleGenerator = new ScheduleGeneratorManager();
        $schedule = $scheduleGenerator
            ->addGamesPerDayLimit($dailyLimit)
            ->setScheduleGenerator(new BaseScheduleGeneratorStrategy())
            ->addExtraTeamNameForOddCount('отдых')
            ->generate($teams);

        $this->assertSame($expected, $schedule);
    }


    public static function teamsProvider(): array
    {
        return [
            'default' => [
                4,
                ['k1', 'k2', 'k3', 'k4', 'k5', 'k6'],
                [
                    '1' => [
                        'k1' => 'k6',
                        'k2' => 'k5',
                        'k3' => 'k4'
                    ],
                    '2' => [
                        'k1' => 'k5',
                        'k6' => 'k4',
                        'k2' => 'k3'
                    ],
                    '3' => [
                        'k1' => 'k4',
                        'k5' => 'k3',
                        'k6' => 'k2'
                    ],
                    '4' => [
                        'k1' => 'k3',
                        'k4' => 'k2',
                        'k5' => 'k6'
                    ],
                    '5' => [
                        'k1' => 'k2',
                        'k3' => 'k6',
                        'k4' => 'k5'
                    ]
                ]
            ],
            'oddTeamsCount' => [
                4,
                ['k1', 'k2', 'k3', 'k4', 'k5'],
                [
                    '1' => [
                        'k1' => 'отдых',
                        'k2' => 'k5',
                        'k3' => 'k4'
                    ],
                    '2' => [
                        'k1' => 'k5',
                        'отдых' => 'k4',
                        'k2' => 'k3'
                    ],
                    '3' => [
                        'k1' => 'k4',
                        'k5' => 'k3',
                        'отдых' => 'k2'
                    ],
                    '4' => [
                        'k1' => 'k3',
                        'k4' => 'k2',
                        'k5' => 'отдых'
                    ],
                    '5' => [
                        'k1' => 'k2',
                        'k3' => 'отдых',
                        'k4' => 'k5'
                    ]
                ]
            ],
            'countLessThanDailyLimit' => [
                6,
                ['k1', 'k2', 'k3', 'k4'],
                [
                    '1' => [
                        'k1' => 'k4',
                        'k2' => 'k3',
                    ],
                    '2' => [
                        'k1' => 'k3',
                        'k4' => 'k2',
                    ],
                    '3' => [
                        'k1' => 'k2',
                        'k3' => 'k4',
                    ]
                ]
            ]
        ];
    }

}