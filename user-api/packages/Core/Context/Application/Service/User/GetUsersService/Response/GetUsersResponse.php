<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\GetUsersService\Response;

use JMS\Serializer\Annotation as Serializer;
use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Application\Service\User\DTO\UserDTO;

class GetUsersResponse implements ResponseInterface
{
    /**
     * @var UserDTO[]
     * @Serializer\SerializedName("users")
     */
    private $productPriceChangeDTOs;

    /**
     * @var int
     */
    private $count;

    /**
     * @param UserDTO[] $productPriceChangeDTOs
     */
    public function __construct(array $productPriceChangeDTOs, int $count)
    {
        $this->setProductPriceChangeDTOs(...$productPriceChangeDTOs);
        $this->setCount($count);
    }

    /**
     * @return UserDTO[]
     */
    public function productPriceChangeDTOs(): array
    {
        return $this->productPriceChangeDTOs;
    }

    private function setProductPriceChangeDTOs(UserDTO ...$productPriceChangeDTOs): void
    {
        $this->productPriceChangeDTOs = $productPriceChangeDTOs;
    }

    public function count(): int
    {
        return $this->count;
    }

    private function setCount(int $count): void
    {
        $this->count = $count;
    }
}
