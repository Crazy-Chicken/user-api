<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Security\Authentication;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Common\Exception\AuthenticationLogicException;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Model\Security\UserInterface;

interface SecurityInterface
{
    /**
     * @throws AuthenticationException
     * @throws AuthenticationLogicException
     */
    public function authenticate(AuthenticationRequestInterface $request): void;

    public function user(): ?UserInterface;

    public function isAuthenticated(): bool;
}
