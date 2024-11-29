<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Repository\Access;

use UserApi\Core\Context\Domain\Exception\ResourceByParameterNotFoundException;
use UserApi\Core\Context\Domain\Model\Access\Access;
use UserApi\Core\Context\Domain\Model\Access\AccessID;
use UserApi\Core\Context\Domain\Model\Access\AccessRepositoryInterface;
use UserApi\Core\Context\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;

/**
 * @method Access|null find(AccessID $id)
 * @method Access      findOrFail(AccessID $id)
 * @method Access[]    findAll()
 * @method Access[]    findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method Access|null findOneBy(array $criteria, array $orderBy = null)
 */
class DoctrineAccessRepository extends DoctrineRepository implements AccessRepositoryInterface
{
    public function getClassName(): string
    {
        return Access::class;
    }

    public function findByNick(string $accessNick): Access
    {
        $result = $this->createQueryBuilder('a')
            ->andWhere("a.nick LIKE :accessNick")
            ->setParameter('accessNick', $accessNick)
            ->getQuery()
            ->getOneOrNullResult();
        if ($result === null) {
            throw new ResourceByParameterNotFoundException($accessNick);
        }
        return $result;
    }
}
