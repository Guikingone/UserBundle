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
 * Class ForgotPasswordEvent.
 *
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
class ForgotPasswordEvent extends Event
{
    const NAME = 'forgot.password';

    /** @var User */
    protected $user;

    /**
     * ForgotPasswordEvent constructor.
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
