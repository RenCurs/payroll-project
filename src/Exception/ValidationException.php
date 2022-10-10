<?php

namespace App\Exception;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    /**
     * @var string[]
     */
    public array $errors;

    /**
     *  @param string[] $errors
     */
    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }
}
