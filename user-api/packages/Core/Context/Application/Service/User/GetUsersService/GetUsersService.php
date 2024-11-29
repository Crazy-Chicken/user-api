<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\GetUsersService;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Context\Application\Service\ApplicationService;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Application\Service\User\DTO\UserDTO;
use UserApi\Core\Context\Application\Service\User\GetUsersService\Request\GetUsersRequest;
use UserApi\Core\Context\Application\Service\User\GetUsersService\Response\GetUsersResponse;
use UserApi\Core\Context\Domain\Model\Access\Access;
use UserApi\Core\Context\Domain\Model\Security\Authentication\SecurityInterface;
use UserApi\Core\Context\Domain\Model\User\User;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;

/**
 * @method GetUsersResponse execute(GetUsersRequest $request);
 */
class GetUsersService extends ApplicationService
{
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
        return $request instanceof GetUsersRequest;
    }

    /**
     * @param GetUsersRequest $request
     *
     * @return GetUsersResponse
     */
    protected function process(RequestInterface $request): ResponseInterface
    {
        /** @var User|null $user */
        $user = $this->security->user();
        if ($user === null) {
            throw new AuthenticationException('Access denied.');
        }

        if ($request->userID() !== null) {
            if ($user->ID()->equals($request->userID())
                || $user->hasAccessByNick(Access::GET_USERS)) {
                $users[] = new UserDTO($this->userRepository->find($request->userID()));
                return new GetUsersResponse($users, count($users));
            } else {
                throw new AuthenticationException('Access denied.');
            }
        }

        if (! $user->hasAccessByNick(Access::GET_USERS)) {
            $user = new UserDTO($this->userRepository->find($user->ID()));
            return new GetUsersResponse([$user], 1);
        }

        $users = $this->userRepository->findByPager()
            ->setMaxPerPage($request->perPage())
            ->setCurrentPage($request->page());
        $count = $users->count();
        $users = array_map(function (User $user) {
            return new UserDTO($user);
        }, iterator_to_array($users));

        return new GetUsersResponse($users, $count);
    }
}
