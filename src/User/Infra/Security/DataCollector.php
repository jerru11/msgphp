<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Security;

use MsgPhp\Domain\Exception\EntityNotFoundException;
use MsgPhp\Domain\Factory\EntityFactoryInterface;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Repository\UserRepositoryInterface;
use Symfony\Bundle\SecurityBundle\DataCollector\SecurityDataCollector as BaseDataCollector;
use Symfony\Bundle\SecurityBundle\Debug\TraceableFirewallListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Http\FirewallMapInterface;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class DataCollector extends BaseDataCollector
{
    private $repository;
    private $factory;

    public function __construct(TokenStorageInterface $tokenStorage = null, RoleHierarchyInterface $roleHierarchy = null, LogoutUrlGenerator $logoutUrlGenerator = null, AccessDecisionManagerInterface $accessDecisionManager = null, FirewallMapInterface $firewallMap = null, TraceableFirewallListener $firewall = null, UserRepositoryInterface $repository = null, EntityFactoryInterface $factory = null)
    {
        parent::__construct($tokenStorage, $roleHierarchy, $logoutUrlGenerator, $accessDecisionManager, $firewallMap, $firewall);

        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
        parent::collect($request, $response, $exception);

        if (isset($this->data['user'])) {
            $this->data['user'] = $this->getUsername($this->data['user']);
        }

        if (isset($this->data['impersonator_user'])) {
            $this->data['impersonator_user'] = $this->getUsername($this->data['impersonator_user']);
        }
    }

    private function getUsername(string $user): string
    {
        if (null === $this->repository) {
            return $user;
        }

        if (null === $this->factory) {
            throw new \LogicException('No entity factory set.');
        }

        try {
            return $this->repository->find($this->factory->identify(User::class, $user))
                ->getCredential()
                ->getUsername();
        } catch (EntityNotFoundException $e) {
            return $user;
        }
    }
}
