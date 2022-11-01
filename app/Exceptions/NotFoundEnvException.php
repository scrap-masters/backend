<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class NotFoundEnvException extends Exception
{
    public static function withMessage(string $message, ?Throwable $previous = null): self
    {
        return new self(
            $message,
            500,
            $previous,
        );
    }
}
