<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Application\Service\User\UpdateUserService;

use UserApi\Core\Common\Exception\AuthenticationException;
use UserApi\Core\Context\Application\Service\ApplicationService;
use UserApi\Core\Context\Application\Service\RequestInterface;
use UserApi\Core\Context\Application\Service\ResponseInterface;
use UserApi\Core\Context\Application\Service\User\UpdateUserService\Request\UpdateUserRequest;
use UserApi\Core\Context\Application\Service\User\UpdateUserService\Response\UpdateUserResponse;
use UserApi\Core\Context\Domain\Model\Access\Access;
use UserApi\Core\Context\Domain\Model\Access\AccessRepositoryInterface;
use UserApi\Core\Context\Domain\Model\Security\Authentication\SecurityInterface;
use UserApi\Core\Context\Domain\Model\User\User;
use UserApi\Core\Context\Domain\Model\User\UserName\UserName;
use UserApi\Core\Context\Domain\Model\User\UserRepositoryInterface;
use UserApi\Core\Context\Domain\Service\EntityManagerAwareTrait;

/**
 * @method UpdateUserResponse execute(UpdateUserRequest $request);
 */
class UpdateUserService extends ApplicationService
{
    use EntityManagerAwareTrait;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var AccessRepositoryInterface
     */
    private $accessRepository;

    /**
     * @var SecurityInterface
     */
    private $security;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccessRepositoryInterface $accessRepository,
        SecurityInterface $security
    ) {
        $this->userRepository = $userRepository;
        $this->accessRepository = $accessRepository;
        $this->security = $security;
    }

    protected function supports(RequestInterface $request): bool
    {
        return $request instanceof UpdateUserRequest;
    }

    /**
     * @param UpdateUserRequest $request
     *
     * @return UpdateUserResponse
     */
    protected function process(RequestInterface $request): ResponseInterface
    {
        /** @var User|null $thisUser */
        $thisUser = $this->security->user();
        if ($thisUser === null || (! $thisUser->hasAccessByNick(Access::UPDATE_USERS) && ! $thisUser->ID()->equals($request->userID()))) {
            throw new AuthenticationException('Access denied.');
        }
        if (count($request->accessesNick()) !== 0 && ! $thisUser->hasAccessByNick(Access::GIVE_ACCESS)) {
            throw new AuthenticationException('Access denied.');
        }

        $user = $this->userRepository->findOrFail($request->userID());
        $accesses = array_map(function (string $nick) {
            return $this->accessRepository->findByNick($nick);
        }, $request->accessesNick());

        $this->em()->transactional(
            function () use ($user, $accesses, $request) {
                $user->updateName(
                    new UserName(
                        mb_convert_encoding($request->name()->firstName(), 'windows-1251', 'utf-8'),
                        mb_convert_encoding($request->name()->secondName(), 'windows-1251', 'utf-8'),
                        mb_convert_encoding($request->name()->lastName(), 'windows-1251', 'utf-8')
                    )
                );
                if (count($accesses) !== 0) {
                    $user->updateAccesses(...$accesses);
                }
            }
        );

        return new UpdateUserResponse();
    }
}
