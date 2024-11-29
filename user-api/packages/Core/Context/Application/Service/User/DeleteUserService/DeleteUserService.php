<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\DeleteUserService;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Context\Application\Service\ApplicationService;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Application\Service\User\DeleteUserService\Request\DeleteUserRequest;
use UserApi\Core\Context\Application\Service\User\DeleteUserService\Response\DeleteUserResponse;
use UserApi\Core\Context\Domain\Model\Access\Access;
use UserApi\Core\Context\Domain\Model\Security\Authentication\SecurityInterface;
use UserApi\Core\Context\Domain\Model\User\User;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;
use UserApi\Core\Context\Domain\Service\EntityManagerAwareTrait;

/**
 * @method DeleteUserResponse execute(DeleteUserRequest $request);
 */
class DeleteUserService extends ApplicationService
{
    use EntityManagerAwareTrait;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var SecurityInterface
     */
    private $security;

    public function __construct(UserRepositoryInterface $userRepository, SecurityInterface $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    protected function supports(RequestInterface $request): bool
    {
        return $request instanceof DeleteUserRequest;
    }

    /**
     * @param DeleteUserRequest $request
     *
     * @return DeleteUserResponse
     */
    protected function process(RequestInterface $request): ResponseInterface
    {
        /** @var User|null $user */
        $user = $this->security->user();
        if ($user === null || (! $user->hasAccessByNick(Access::DELETE_USERS) && ! $user->ID()->equals($request->userID()))) {
            throw new AuthenticationException('Access denied.');
        }

        $user = $this->userRepository->findOrFail($request->userID());
        $this->userRepository->remove($user);

        return new DeleteUserResponse();
    }
}
