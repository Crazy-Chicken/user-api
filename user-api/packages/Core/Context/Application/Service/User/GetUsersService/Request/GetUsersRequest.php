<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\GetUsersService\Request;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation as Serializer;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Domain\Model\User\UserID;

class GetUsersRequest implements RequestInterface
{
    /**
     * @var ?UserID
     * @Serializer\Type("string")
     * @Serializer\SerializedName("user_id")
     * @Accessor(setter="setUserID")
     */
    private $userID = null;

    /**
     * @var int
     * @Serializer\Type("int")
     * @Serializer\SerializedName("page")
     */
    private $page = 1;

    /**
     * @var int
     * @Serializer\Type("int")
     * @Serializer\SerializedName("per_page")
     */
    private $perPage = 50;

    public function __construct(
        int $page,
        int $perPage,
        ?string $userID = null
    ) {
        $this->setPage($page);
        $this->setPerPage($perPage);
        $this->setUserID($userID);
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    private function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    public function page(): int
    {
        return $this->page;
    }

    private function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function userID(): ?UserID
    {
        return $this->userID;
    }

    public function setUserID(?string $userID): void
    {
        $this->userID = $userID !== null ? new UserID($userID) : null;
    }
}
