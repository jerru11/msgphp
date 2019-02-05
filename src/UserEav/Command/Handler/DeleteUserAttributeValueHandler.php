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

namespace MsgPhp\User\Command\Handler;

use MsgPhp\Domain\Exception\EntityNotFoundException;
use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;
use MsgPhp\Domain\Message\{DomainMessageBusInterface, MessageDispatchingTrait};
use MsgPhp\User\Command\DeleteUserAttributeValueCommand;
use MsgPhp\User\Event\UserAttributeValueDeletedEvent;
use MsgPhp\User\Repository\UserAttributeValueRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DeleteUserAttributeValueHandler
{
    use MessageDispatchingTrait;

    /**
     * @var UserAttributeValueRepositoryInterface
     */
    private $repository;

    public function __construct(DomainObjectFactoryInterface $factory, DomainMessageBusInterface $bus, UserAttributeValueRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(DeleteUserAttributeValueCommand $command): void
    {
        try {
            $userAttributeValue = $this->repository->find($command->attributeValueId);
        } catch (EntityNotFoundException $e) {
            return;
        }

        $this->repository->delete($userAttributeValue);
        $this->dispatch(UserAttributeValueDeletedEvent::class, compact('userAttributeValue'));
    }
}
