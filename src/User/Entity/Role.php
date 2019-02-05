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

namespace MsgPhp\User\Entity;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
abstract class Role
{
    abstract public function getName(): string;
}
