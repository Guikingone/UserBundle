<?php

/*
 * This file is part of the GuikingoneUserBundle project.
 *
 * (c) Guillaume Loulier <contact@guillaumeloulier.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\UserBundle\Controllers\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

// Controllers
use UserBundle\Controller\Api\SecurityController;

// Services
use UserBundle\Services\Api\Security;

/**
 * Class SecurityControllerTest.
 *
 * @author Guillaume Loulier <contact@guillaumeloulier.fr>
 */
class SecurityControllerTest extends WebTestCase
{
    /** @var null */
    private $client;

    /** {@inheritdoc} */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->client->enableProfiler();
    }

    /**
     * Test if the register method work.
     *
     * @see SecurityController::registerAction()
     * @see Security::register()
     */
    public function testApiRegister()
    {
        $this->client->request('POST', '/api/register', [
            'email' => 'nanarland@world.fr',
            'username' => 'NanarLand',
            'plainPassword' => 'Ie1FDLNNA@',
        ]);

        $mailer = $this->client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(
            Response::HTTP_CREATED,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertEquals(1, $mailer->getMessageCount());

        $collectedMessages = $mailer->getMessages();
        $message = $collectedMessages[0];

        $this->assertInstanceOf(\Swift_Message::class, $message);
        $this->assertEquals('Snowtricks - Notification system', $message->getSubject());
        $this->assertEquals('contact@snowtricks.fr', key($message->getFrom()));
    }

    /**
     * Test if the register method work.
     *
     * @see SecurityController::registerAction()
     * @see Security::register()
     */
    public function testApiRegister_Failure_BadInput()
    {
        $this->client->request('POST', '/api/register', [
            'email' => 'nanarland@world.fr',
            'user' => 'NanarLand',
            'password' => 'Ie1FDLNNA@',
        ]);

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if the login method accept the request.
     *
     * @see SecurityController::loginAction()
     * @see Security::login()
     */
    public function testApiLogin()
    {
        $this->client->request('POST', '/api/login', [
            '_username' => 'NanarLand',
            '_password' => 'Ie1FDLNNA@',
        ]);

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if the login method accept the request with wrong input.
     *
     * @see SecurityController::loginAction()
     * @see Security::login()
     */
    public function testApiLogin_Failure_BadInput()
    {
        $this->client->request('POST', '/api/login', [
            'email' => 'nanarland@world.fr',
            'password' => 'Ie1FDLNNA',
        ]);

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if the login method accept the request.
     *
     * @see SecurityController::loginAction()
     * @see Security::login()
     */
    public function testApiLogin_Failure_BadInfos()
    {
        $this->client->request('POST', '/api/login', [
            '_username' => 'Root',
            '_password' => 'Ie1Fpodm',
        ]);

        $this->assertEquals(
            Response::HTTP_FOUND,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if the forgot password action work with valid input.
     *
     * @see SecurityController::forgotPasswordAction()
     * @see Security::forgotPassword()
     */
    public function testApiForgotPassword()
    {
        $this->client->request('POST', '/api/forgot/password', [
            'email' => 'nanarland@world.fr',
            'username' => 'NanarLand',
        ]);

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if the forgot password action work with valid input.
     *
     * @see SecurityController::forgotPasswordAction()
     * @see Security::forgotPassword()
     */
    public function testApiForgotPassword_Failure_BadInfos()
    {
        $this->client->request('POST', '/api/forgot/password', [
            'email' => 'nanarland@world.fr',
            'username' => 'Gringuoli',
        ]);

        $this->assertEquals(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if the forgot password action work with wrong input.
     *
     * @see SecurityController::forgotPasswordAction()
     * @see Security::forgotPassword()
     */
    public function testApiForgotPassword_Failure_BadInput()
    {
        $this->client->request('POST', '/api/forgot/password', [
            'email' => 'NanarLand',
            'username' => 'nanarland@world.fr',
        ]);

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if a user can validate his profile using a token.
     *
     * @see SecurityController::validatedProfileAction()
     * @see Security::validateUser()
     */
    public function testApiValidateUser()
    {
        $this->client->request('GET', '/api/validate/profile/token_e61e26a5a42d35472');

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if a user can validate his profile using a token.
     *
     * @see SecurityController::validatedProfileAction()
     * @see Security::validateUser()
     */
    public function testApiValidateUser_TokenAlreadyValidated()
    {
        $this->client->request('GET', '/api/validate/profile/token_e61e26a5a42d3g9r4');

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $this->client->getResponse()->getStatusCode()
        );
    }

    /**
     * Test if a user can validate his profile using a token.
     *
     * @see SecurityController::validatedProfileAction()
     * @see Security::validateUser()
     */
    public function testApiValidateUser_InvalidToken()
    {
        $this->client->request('GET', '/api/validate/profile/e61e26a5a42d35472');

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $this->client->getResponse()->getStatusCode()
        );
    }
}
