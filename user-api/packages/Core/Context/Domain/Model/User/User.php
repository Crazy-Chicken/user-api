<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use UserApi\Core\Context\Domain\Model\Access\Access;
use UserApi\Core\Context\Domain\Model\ResourceInterface;
use UserApi\Core\Context\Domain\Model\Security\UserInterface;
use UserApi\Core\Context\Domain\Model\User\UserName\UserName;

class User implements ResourceInterface, UserInterface
{
    /**
     * @var UserID
     */
    private $ID;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var UserName
     */
    private $name;

    /**
     * @var \DateTimeImmutable
     */
    private $updateDate;

    /**
     * @var Collection<int|string, Access>
     */
    private $accesses;

    public function __construct(
        UserID $ID,
        string $login,
        string $password,
        UserName $name
    ) {
        $this->setID($ID);
        $this->setLogin($login);
        $this->setPassword($password);
        $this->setName($name);
        $this->setUpdateDate();
        $this->setAccesses();
    }

    public function ID(): UserID
    {
        return $this->ID;
    }

    private function setID(UserID $ID): void
    {
        $this->ID = $ID;
    }

    public function login(): string
    {
        return $this->login;
    }

    private function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function password(): string
    {
        return $this->password;
    }

    private function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function equalsPassword(string $password): bool
    {
        return password_verify($password, $this->password());
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function updateName(UserName $name): void
    {
        $this->setName($name);
        $this->setUpdateDate();
    }

    private function setName(UserName $name): void
    {
        $this->name = $name;
    }

    public function updateDate(): \DateTimeImmutable
    {
        return $this->updateDate;
    }

    public function setUpdateDate(): void
    {
        $this->updateDate = new \DateTimeImmutable();
    }

    /**
     * @return Access[]
     */
    public function accesses(): array
    {
        return $this->accesses->toArray();
    }

    private function setAccesses(Access ...$accesses): void
    {
        $this->accesses = new ArrayCollection();
        array_map([$this, 'addAccess'], $accesses);
    }

    public function addAccess(Access $access): void
    {
        if (false === $this->hasAccess($access)) {
            $this->accesses->add($access);
            $this->setUpdateDate();
        }
    }

    public function removeAccess(Access $access): void
    {
        if (true === $this->hasAccess($access)) {
            $this->accesses->removeElement($access);
            $this->setUpdateDate();
        }
    }

    public function updateAccesses(Access ...$accesses): void
    {
        foreach ($this->accesses as $access) {
            if (false === in_array($access, $accesses, true)) {
                $this->removeAccess($access);
            }
        }
        array_map([$this, 'addAccess'], $accesses);
    }

    public function hasAccess(Access $access): bool
    {
        return $this->accesses->contains($access);
    }

    public function hasAccessByNick(string $accessNick): bool
    {
        return $this->accesses->exists(function (int $key, Access $access) use ($accessNick) {
            return $access->nick() === $accessNick;
        });
    }
}
