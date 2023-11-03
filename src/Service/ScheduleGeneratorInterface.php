<?php

namespace App\Service;

use App\Entity\Team;

interface ScheduleGeneratorInterface
{
    /**
     * @param Team[] $teams
     * @return array
     */
    public function generate(array $teams): array;
}