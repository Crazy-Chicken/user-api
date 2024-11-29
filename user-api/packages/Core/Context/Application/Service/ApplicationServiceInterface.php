<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service;

interface ApplicationServiceInterface
{
    public function execute(RequestInterface $request): ResponseInterface;
}
