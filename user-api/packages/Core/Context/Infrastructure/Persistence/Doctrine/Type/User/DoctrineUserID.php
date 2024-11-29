<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Type\User;

use UserApi\Core\Common\Model\UUID;
use UserApi\Core\Context\Domain\Model\User\UserID;
use UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Type\DoctrineUuidBinaryType;

class DoctrineUserID extends DoctrineUuidBinaryType
{
    public const NAME = 'UserID';

    protected function convertToConcreteClass(UUID $uuid)
    {
        return new UserID($uuid->__toString());
    }
}
