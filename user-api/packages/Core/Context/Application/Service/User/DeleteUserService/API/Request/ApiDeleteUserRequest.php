<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\DeleteUserService\API\Request;

use UserApi\Core\Context\Application\Service\User\DeleteUserService\Request\DeleteUserRequest;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Service\AuthenticationTokenTrait;

class ApiDeleteUserRequest extends DeleteUserRequest implements AuthenticationRequestInterface
{
    use AuthenticationTokenTrait;
}
