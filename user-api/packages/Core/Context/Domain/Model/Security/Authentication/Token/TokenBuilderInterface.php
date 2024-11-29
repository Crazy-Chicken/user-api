<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Security\Authentication\Token;

use UserApi\Core\Context\Domain\Model\Security\UserInterface;

interface TokenBuilderInterface
{
    public function createToken(UserInterface $user): string;
}
