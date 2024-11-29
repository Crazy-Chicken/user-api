<?php

declare(strict_types=1);

namespace UserApi\Core\Common\Pager;

interface PagerAdapterInterface
{
    public function nbResults(): int;

    /**
     * @return iterable<mixed>
     */
    public function slice(int $offset, int $length): iterable;
}
