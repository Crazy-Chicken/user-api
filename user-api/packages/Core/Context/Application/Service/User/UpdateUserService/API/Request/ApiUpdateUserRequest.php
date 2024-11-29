<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\UpdateUserService\API\Request;

use UserApi\Core\Context\Application\Service\User\UpdateUserService\Request\UpdateUserRequest;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Service\AuthenticationTokenTrait;

class ApiUpdateUserRequest extends UpdateUserRequest implements AuthenticationRequestInterface
{
    use AuthenticationTokenTrait;
}
