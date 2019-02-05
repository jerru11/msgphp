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

namespace MsgPhp\User\Event\Domain;

use MsgPhp\Domain\Event\DomainEventInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ChangeCredentialEvent implements DomainEventInterface
{
    /**
     * @var array
     */
    public $fields;

    final public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
}
