<?php
declare(strict_types=1);

namespace Stancer\Exceptions;

use Stancer\Interfaces\ExceptionInterface;
use Psr;

/**
 * Exception thrown on miss-validation with expiration date.
 */
class InvalidExpirationException extends InvalidArgumentException implements ExceptionInterface
{
    /** @var string Default log level */
    protected static $logLevel = Psr\Log\LogLevel::DEBUG;

    /**
     * Return default message for that kind of exception.
     *
     * @return string
     */
    public static function getDefaultMessage(): string
    {
        return 'Expiration is invalid.';
    }
}