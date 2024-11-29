<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\Security\ApiAuthenticationService;

use UserApi\Core\Context\Application\Service\ApplicationService;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Application\Service\Security\ApiAuthenticationService\Request\ApiAuthenticationRequest;
use UserApi\Core\Context\Application\Service\Security\ApiAuthenticationService\Response\ApiAuthenticationResponse;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticatorInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\Token\TokenBuilderInterface;
use UserApi\Core\Context\Domain\Model\User\User;

/**
 * @method ApiAuthenticationResponse execute(ApiAuthenticationRequest $request);
 */
class ApiAuthenticationService extends ApplicationService
{
    /**
     * @var AuthenticatorInterface
     */
    private $authenticator;

    /**
     * @var TokenBuilderInterface
     */
    private $tokenBuilder;

    public function __construct(
        AuthenticatorInterface $authenticator,
        TokenBuilderInterface $tokenBuilder
    ) {
        $this->authenticator = $authenticator;
        $this->tokenBuilder = $tokenBuilder;
    }

    protected function supports(RequestInterface $request): bool
    {
        return $request instanceof ApiAuthenticationRequest;
    }

    /**
     * @param ApiAuthenticationRequest $request
     *
     * @return ApiAuthenticationResponse
     */
    protected function process(RequestInterface $request): ResponseInterface
    {
        /** @var User $user */
        $user = ($this->authenticator->authenticate($request))->user();

        return new ApiAuthenticationResponse($this->tokenBuilder->createToken($user), $user->ID());
    }
}
