<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\User;

use UserApi\Core\Common\Pager\Pager;
use UserApi\Core\Context\Domain\Model\RepositoryInterface;

/**
 * @method User|null find(UserID $id)
 * @method User      findOrFail(UserID $id)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByPager(): Pager;
}
