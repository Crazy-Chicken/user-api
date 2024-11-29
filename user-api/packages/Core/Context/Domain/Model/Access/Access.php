<?php

declare(strict_types=1);

namespace UserApi\Core\Context\Domain\Model\Access;

use UserApi\Core\Context\Domain\Model\ResourceInterface;

class Access implements ResourceInterface
{
    public const UPDATE_USERS = 'UPDATE_USERS';

    public const DELETE_USERS = 'DELETE_USERS';

    public const GET_USERS = 'GET_USERS';

    public const GIVE_ACCESS = 'GIVE_ACCESS';

    /**
     * @var AccessID
     */
    private $ID;

    /**
     * @var string
     */
    private $nick;

    /**
     * @var string
     */
    private $name;

    public function __construct(AccessID $ID, string $nick, string $name)
    {
        $this->setID($ID);
        $this->setNick($nick);
        $this->setName($name);
    }

    public function ID(): AccessID
    {
        return $this->ID;
    }

    private function setID(AccessID $ID): void
    {
        $this->ID = $ID;
    }

    public function nick(): string
    {
        return $this->nick;
    }

    private function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function name(): string
    {
        return $this->name;
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }
}
