<?php

/*
 * This file is part of the GuikingoneUserBundle project.
 *
 * (c) Guillaume Loulier <contact@guillaumeloulier.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guikingone\UserBundle\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Responder
 *
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
final class Responder
{
    public function __invoke ()
    {
        new return new JsonResponse()
    }
}