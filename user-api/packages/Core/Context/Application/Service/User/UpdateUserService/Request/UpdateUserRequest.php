<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\UpdateUserService\Request;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation as Serializer;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Application\Service\User\DTO\UserNameDTO;
use UserApi\Core\Context\Domain\Model\User\UserID;

class UpdateUserRequest implements RequestInterface
{
    /**
     * @var UserID
     * @Serializer\Type("string")
     * @Serializer\SerializedName("user_id")
     * @Accessor(setter="setUserID")
     */
    private $userID;

    /**
     * @var UserNameDTO
     * @Serializer\Type("UserApi\Core\Context\Application\Service\User\DTO\UserNameDTO")
     * @Serializer\SerializedName("name")
     */
    private $name;

    /**
     * @var string[]
     * @Serializer\Type("array<string>")
     * @Serializer\SerializedName("accesses_nick")
     */
    private $accessesNick = [];

    /**
     * @param string[] $accessesNick
     */
    public function __construct(string $userID, UserNameDTO $userNameDTO, array $accessesNick)
    {
        $this->setUserID($userID);
        $this->setName($userNameDTO);
        $this->setAccessesNick(...$accessesNick);
    }

    public function userID(): UserID
    {
        return $this->userID;
    }

    public function setUserID(string $userID): void
    {
        $this->userID = new UserID($userID);
    }

    public function name(): UserNameDTO
    {
        return $this->name;
    }

    private function setName(UserNameDTO $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string[]
     */
    public function accessesNick(): array
    {
        return $this->accessesNick;
    }

    private function setAccessesNick(string ...$accessesNick): void
    {
        $this->accessesNick = $accessesNick;
    }
}
