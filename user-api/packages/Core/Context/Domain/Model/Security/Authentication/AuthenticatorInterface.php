<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Security\Authentication;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;

interface AuthenticatorInterface
{
    public function supports(AuthenticationRequestInterface $request): bool;

    /**
     * @throws AuthenticationException
     */
    public function authenticate(AuthenticationRequestInterface $request): AuthenticationResponse;
}
