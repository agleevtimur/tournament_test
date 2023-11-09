<?php

namespace App\Service\ScheduleGenerator\Exception;


use Exception;
use Throwable;

class ScheduleGeneratorStrategyException extends Exception
{
    private string $errorMessage = "Стратегия разработки расписания не определена";
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($this->errorMessage, $code, $previous);
    }
}