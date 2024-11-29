<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\DeleteUserService\Request;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation as Serializer;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Domain\Model\User\UserID;

class DeleteUserRequest implements RequestInterface
{
    /**
     * @var UserID
     * @Serializer\Type("string")
     * @Serializer\SerializedName("user_id")
     * @Accessor(setter="setUserID")
     */
    private $userID;

    public function __construct(string $userID)
    {
        $this->setUserID($userID);
    }

    public function userID(): UserID
    {
        return $this->userID;
    }

    public function setUserID(string $userID): void
    {
        $this->userID = new UserID($userID);
    }
}
