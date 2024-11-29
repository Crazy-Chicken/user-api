<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Security\Authentication\Token;

interface HashTokenGeneratorInterface
{
    public function secret(): string;

    public function delimiter(): ?string;

    public function lifeTime(): int;

    public function generateHash(HashDataInterface $data): string;
}
