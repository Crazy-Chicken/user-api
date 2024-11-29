<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Service\Security\Authenticator;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Common\Exception\AuthenticationLogicException;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationRequest\AuthenticationRequestInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticationResponse;
use UserApi\Core\Context\Domain\Model\Security\Authentication\AuthenticatorInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\Token\HashTokenGeneratorInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\Token\TokenEncoderInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\Token\WebToken\HashDataWebToken;
use UserApi\Core\Context\Domain\Model\Security\Authentication\UserChecker\UserCheckerInterface;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;

class TokenAuthenticator implements AuthenticatorInterface
{
    /**
     * @var TokenEncoderInterface
     */
    private $tokenEncoder;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * @var HashTokenGeneratorInterface
     */
    private $hashTokenGenerator;

    public function __construct(
        TokenEncoderInterface $tokenEncoder,
        HashTokenGeneratorInterface $hashTokenGenerator,
        UserRepositoryInterface $userRepository,
        UserCheckerInterface $userChecker
    ) {
        $this->setTokenEncoder($tokenEncoder);
        $this->setUserRepository($userRepository);
        $this->setUserChecker($userChecker);
        $this->setHashTokenGenerator($hashTokenGenerator);
    }

    private function tokenEncoder(): TokenEncoderInterface
    {
        return $this->tokenEncoder;
    }

    private function userRepository(): UserRepositoryInterface
    {
        return $this->userRepository;
    }

    private function userChecker(): UserCheckerInterface
    {
        return $this->userChecker;
    }

    private function hashTokenGenerator(): HashTokenGeneratorInterface
    {
        return $this->hashTokenGenerator;
    }

    private function setTokenEncoder(TokenEncoderInterface $tokenEncoder): void
    {
        $this->tokenEncoder = $tokenEncoder;
    }

    private function setUserRepository(UserRepositoryInterface $userRepository): void
    {
        $this->userRepository = $userRepository;
    }

    private function setUserChecker(UserCheckerInterface $userChecker): void
    {
        $this->userChecker = $userChecker;
    }

    private function setHashTokenGenerator(HashTokenGeneratorInterface $hashTokenGenerator): void
    {
        $this->hashTokenGenerator = $hashTokenGenerator;
    }

    public function supports(AuthenticationRequestInterface $request): bool
    {
        return null !== $request->authenticationToken();
    }

    public function authenticate(AuthenticationRequestInterface $request): AuthenticationResponse
    {
        if (null === $request->authenticationToken()) {
            throw new AuthenticationLogicException('$request do not have token.');
        }

        [$login, $expires, $hash] = $this->tokenEncoder()->decode(
            $request->authenticationToken(),
            $this->hashTokenGenerator()->delimiter()
        );

        $user = $this->userRepository()->findOneBy([
            'login' => $login,
        ]);

        $this->userChecker()->checkUser($user);

        $hashTokenGenerated = $this->hashTokenGenerator()->generateHash(
            new HashDataWebToken(
                $user->login(),
                (int) $expires,
                $user->password()
            )
        );

        if (true !== hash_equals($hashTokenGenerated, $hash)) {
            throw new AuthenticationException('The token\'s hash is invalid.');
        }

        if ((int) $expires < time()) {
            throw new AuthenticationException('The token has expired.');
        }

        return new AuthenticationResponse($user, true);
    }
}
