<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Service\Security\Authenticator;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Common\Exception\AuthenticationLogicException;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\LoginAuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationResponse;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticatorInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\UserChecker\UserCheckerInterface;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;

class LoginAuthenticator implements AuthenticatorInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserCheckerInterface $userChecker
    ) {
        $this->userRepository = $userRepository;
        $this->userChecker = $userChecker;
    }

    public function supports(AuthenticationRequestInterface $request): bool
    {
        return $request instanceof LoginAuthenticationRequestInterface;
    }

    /**
     * @param AuthenticationRequestInterface|LoginAuthenticationRequestInterface $request
     */
    public function authenticate(AuthenticationRequestInterface $request): AuthenticationResponse
    {
        if (! $request instanceof LoginAuthenticationRequestInterface) {
            throw new AuthenticationLogicException(sprintf('$request must implement interface "%s"', LoginAuthenticationRequestInterface::class));
        }

        $user = $this->userRepository->findOneBy([
            'login' => $request->login(),
        ]);

        $this->userChecker->checkUser($user);

        if (false === $user->equalsPassword($request->password())) {
            throw new AuthenticationException('Bad password.');
        }

        return new AuthenticationResponse($user, true);
    }
}
