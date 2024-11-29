<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Repository\User;

use UserApi\Core\Common\Pager\Pager;
use UserApi\Core\Context\Domain\Model\User\User;
use UserApi\Core\Context\Domain\Model\User\UserID;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;
use UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

/**
 * @method User|null find(UserID $id)
 * @method User      findOrFail(UserID $id)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 */
class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    public function getClassName(): string
    {
        return User::class;
    }

    public function findByPager(): Pager
    {
        return $this->getPaginator(
            $this->createQueryBuilder('u')
        );
    }
}
