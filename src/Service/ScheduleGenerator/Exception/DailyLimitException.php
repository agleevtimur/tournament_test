<?php

namespace App\Service\ScheduleGenerator\Exception;

use Exception;
use Throwable;

class DailyLimitException extends Exception
{
    private string $errorMessage = "Лимит дневных игр не задан";
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($this->errorMessage, $code, $previous);
    }
}