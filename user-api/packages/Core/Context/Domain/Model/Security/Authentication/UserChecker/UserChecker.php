<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Security\Authentication\UserChecker;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Context\Domain\Model\Security\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkUser(?UserInterface $user): void
    {
        if (null === $user) {
            throw new AuthenticationException('The User does not exist.');
        }
    }
}
