<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\Security\ApiCreateAccountService\Response;

use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Domain\Model\User\UserID;

class ApiCreateAccountResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $userID;

    public function __construct(string $token, UserID $userID)
    {
        $this->setToken($token);
        $this->setUserID($userID);
    }

    public function token(): string
    {
        return $this->token;
    }

    private function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function userID(): string
    {
        return $this->userID;
    }

    private function setUserID(UserID $userID): void
    {
        $this->userID = (string) $userID;
    }
}
