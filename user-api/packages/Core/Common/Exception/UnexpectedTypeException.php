<?php

declare(strict_types=1);

namespace UserApi\Core\Common\Exception;

class UnexpectedTypeException extends \InvalidArgumentException
{
    /**
     * @param mixed  $value
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct(
            sprintf(
                'Ожидался аргумент типа "%s", получен "%s".',
                $expectedType,
                is_object($value) ? get_class($value) : gettype($value)
            )
        );
    }
}
