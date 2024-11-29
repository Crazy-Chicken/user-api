<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Access;

use UserApi\Core\Context\Domain\Model\RepositoryInterface;

/**
 * @method Access|null find(AccessID $id)
 * @method Access      findOrFail(AccessID $id)
 * @method Access[]    findAll()
 * @method Access[]    findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method Access|null findOneBy(array $criteria, array $orderBy = null)
 */
interface AccessRepositoryInterface extends RepositoryInterface
{
    public function findByNick(string $accessNick): Access;
}
