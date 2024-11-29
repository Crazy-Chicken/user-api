<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\GetUsersService\API\Request;

use UserApi\Core\Context\Application\Service\User\GetUsersService\Request\GetUsersRequest;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Service\AuthenticationTokenTrait;

class ApiGetUsersRequest extends GetUsersRequest implements AuthenticationRequestInterface
{
    use AuthenticationTokenTrait;
}
