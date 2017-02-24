<?php

/*
 * This file is part of the GuikingoneUserBundle project.
 *
 * (c) Guillaume Loulier <contact@guillaumeloulier.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guikingone\UserBundle\Action\Api;

use Guikingone\UserBundle\Managers\Api\UserManager;
use Guikingone\UserBundle\Responder\RegisterResponder;

/**
 * Class SecurityRegisterAction
 *
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class SecurityRegisterAction
{
    /** @var UserManager */
    private $userManager;

    /** @var RegisterResponder */
    private $registerResponder;

    /**
     * SecurityRegisterAction constructor.
     *
     * @param UserManager       $userManager
     * @param RegisterResponder $registerResponder
     */
    public function __construct (
        UserManager $userManager,
        RegisterResponder $registerResponder
    ) {
        $this->userManager = $userManager;
        $this->registerResponder = $registerResponder;
    }

    public function __invoke ()
    {
        $response = $this->userManager->register();
        $data = $response ? array_key_exists('success', $response) : $response = null;

        $responder = $this->registerResponder;

        return $responder();

    }
}