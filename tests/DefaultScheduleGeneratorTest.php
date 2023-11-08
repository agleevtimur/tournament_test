<?php

namespace App\Tests;

use App\Service\DefaultScheduleGenerator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DefaultScheduleGeneratorTest extends TestCase
{
    #[DataProvider('teamsProvider')]
    public function testGenerate(array $data, array $expected)
    {
        $scheduleGenerator = new DefaultScheduleGenerator();
        $schedule = $scheduleGenerator->generate($data);

        $this->assertSame($schedule, $expected);
    }


    public static function teamsProvider(): array
    {
        return [
            'default' => [
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
            ]
        ];
    }

}