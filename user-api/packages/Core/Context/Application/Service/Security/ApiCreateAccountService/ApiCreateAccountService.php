<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\Security\ApiCreateAccountService;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Context\Application\Service\ApplicationService;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Application\Service\Security\ApiCreateAccountService\Request\ApiCreateAccountRequest;
use UserApi\Core\Context\Application\Service\Security\ApiCreateAccountService\Response\ApiCreateAccountResponse;
use UserApi\Core\Context\Domain\Model\Security\Authentication\Token\TokenBuilderInterface;
use UserApi\Core\Context\Domain\Model\User\User;
use UserApi\Core\Context\Domain\Model\User\UserID;
use UserApi\Core\Context\Domain\Model\User\UserName\UserName;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;

/**
 * @method ApiCreateAccountResponse execute(ApiCreateAccountRequest $request);
 */
class ApiCreateAccountService extends ApplicationService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var TokenBuilderInterface
     */
    private $tokenBuilder;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenBuilderInterface $tokenBuilder
    ) {
        $this->userRepository = $userRepository;
        $this->tokenBuilder = $tokenBuilder;
    }

    protected function supports(RequestInterface $request): bool
    {
        return $request instanceof ApiCreateAccountRequest;
    }

    /**
     * @param ApiCreateAccountRequest $request
     *
     * @return ApiCreateAccountResponse
     */
    protected function process(RequestInterface $request): ResponseInterface
    {
        $user = $this->userRepository->findOneBy([
            'login' => $request->login(),
        ]);
        if ($user !== null) {
            throw new AuthenticationException('User already exists.');
        }

        $user = new User(
            new UserID(),
            $request->login(),
            password_hash($request->password(), PASSWORD_BCRYPT),
            new UserName(
                $request->name()->firstName(),
                $request->name()->secondName(),
                $request->name()->lastName()
            )
        );
        $this->userRepository->add($user);
        return new ApiCreateAccountResponse($this->tokenBuilder->createToken($user), $user->ID());
    }
}
