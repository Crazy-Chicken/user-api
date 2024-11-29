<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Exception;

class ResourceByParameterNotFoundException extends \RuntimeException
{
    public function __construct(string $id)
    {
        parent::__construct(sprintf('Ресурс c параметром "%s" не найден.', $id), 404);
    }
}
