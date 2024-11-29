<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model;

interface ResourceInterface
{
    /**
     * @return mixed
     */
    public function ID();
}
