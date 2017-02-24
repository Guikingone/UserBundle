<?php

/*
 * This file is part of the Snowtricks project.
 *
 * (c) Guillaume Loulier <contact@guillaumeloulier.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guikingone\UserBundle\Events;

use Symfony\Component\EventDispatcher\Event;

// Entity
use Guikingone\UserBundle\Model\Entity\User;

/**
 * Class RegisteredUserEvent
 *
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
class RegisteredUserEvent extends Event
{
    const NAME = 'user.registered';

    /** @var User */
    protected $user;

    /**
     * UserRegistered constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /** @return User */
    public function getUser() : User
    {
        return $this->user;
    }
}
