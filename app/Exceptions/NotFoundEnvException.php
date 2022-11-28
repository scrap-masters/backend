<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NotFoundEnvException extends Exception
{
    public static function withMessage(string $message, ?Throwable $previous = null): self
    {
        return new self(
            $message,
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $previous,
        );
    }
}
