<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service;

use UserApi\Apps\Main\ServiceLocator;
use UserApi\Core\Context\Application\Exception\UnsupportedRequestException;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Service\Security\Authentication\AuthenticationService;

abstract class ApplicationService implements ApplicationServiceInterface
{
    abstract protected function supports(RequestInterface $request): bool;

    /**
     * @throws UnsupportedRequestException
     */
    final public function execute(RequestInterface $request): ResponseInterface
    {
        if (false === $this->supports($request)) {
            throw new UnsupportedRequestException(sprintf('Unsupported request %s.', get_class($request)));
        }

        if ($request instanceof AuthenticationRequestInterface) {
            /** @var AuthenticationService $authService */
            /** @phpstan-ignore-next-line */
            $authService = ServiceLocator::getService('user_api.domain.security.authentication');
            $authService->authenticate($request);
        }

        return $this->process($request);
    }

    abstract protected function process(RequestInterface $request): ResponseInterface;
}
