<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Type\Access;

use UserApi\Core\Common\Model\UUID;
use UserApi\Core\Context\Domain\Model\Access\AccessID;
use UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Type\DoctrineUuidBinaryType;

class DoctrineAccessID extends DoctrineUuidBinaryType
{
    public const NAME = 'AccessID';

    protected function convertToConcreteClass(UUID $uuid)
    {
        return new AccessID($uuid->__toString());
    }
}
