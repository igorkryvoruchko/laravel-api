<?php

namespace App\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    /**
     * ValidatorException constructor.
     * @param $message
     * @param int $code
     * @param Exception|null $previous
     * @param array $options
     */
    public function __construct($message,
                                        $code = null,
                                        Exception $previous = null,
                                        private array $options = [])
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
