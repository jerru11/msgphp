<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\Domain\Infra\ApiPlatform;

use ApiPlatform\Core\DataProvider\PaginatorInterface;
use MsgPhp\Domain\PaginatedDomainCollectionInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class Paginator implements \IteratorAggregate, PaginatorInterface
{
    /**
     * @var PaginatedDomainCollectionInterface
     */
    private $collection;

    public function __construct(PaginatedDomainCollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    public function getIterator(): \Traversable
    {
        return $this->collection->getIterator();
    }

    public function count(): int
    {
        return \count($this->collection);
    }

    public function getLastPage(): float
    {
        return $this->collection->getLastPage();
    }

    public function getTotalItems(): float
    {
        return $this->collection->getTotalCount();
    }

    public function getCurrentPage(): float
    {
        return $this->collection->getCurrentPage();
    }

    public function getItemsPerPage(): float
    {
        return $this->collection->getLimit();
    }
}
