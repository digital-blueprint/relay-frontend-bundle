<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Tests;

use Dbp\Relay\CoreBundle\TestUtils\AbstractApiTest;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends AbstractApiTest
{
    public function testBasics()
    {
        $response = $this->testClient->get('/frontend/users', token: null);
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());

        $response = $this->testClient->get('/frontend/users/foobar', token: null);
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostPut()
    {
        $response = $this->testClient->request('POST', '/frontend/users', token: null);
        $this->assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());

        $response = $this->testClient->request('PUT', '/frontend/users', token: null);
        $this->assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
    }

    public function testAuthCollection()
    {
        $this->testClient->setUpUser('foobar', symfonyRoles: ['ROLE_XXX']);
        $response = $this->testClient->get('/frontend/users');
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $users = $data['hydra:member'];
        $this->assertCount(1, $users);
        $user = $users[0];
        $this->assertSame('/frontend/users/foobar', $user['@id']);
        $this->assertSame(['ROLE_XXX'], $user['roles']);
    }

    public function testAuthUserWithoutRole()
    {
        $this->testClient->setUpUser('foobar');
        $response = $this->testClient->get('/frontend/users/foobar');
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/foobar', $data['@id']);
        $this->assertSame([], $data['roles']);
    }

    public function testAuthUserWithSymfonyRole()
    {
        $this->testClient->setUpUser('foobar', symfonyRoles: ['ROLE_XXX']);
        $response = $this->testClient->get('/frontend/users/foobar');
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/foobar', $data['@id']);
        $this->assertSame(['ROLE_XXX'], $data['roles']);
    }

    public function testAuthUserWithSymfonyRoleAndAddedRole()
    {
        $this->testClient->setUpUser('admin', symfonyRoles: ['ROLE_XXX']);
        $response = $this->testClient->get('/frontend/users/admin');
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/admin', $data['@id']);
        $this->assertCount(2, $data['roles']);
        $this->assertContains('ROLE_XXX', $data['roles']);
        $this->assertContains('ROLE_ADMIN', $data['roles']);
    }

    public function testAuthUserWithAddedRole()
    {
        $this->testClient->setUpUser('franz');
        $response = $this->testClient->get('/frontend/users/franz');
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/franz', $data['@id']);
        $this->assertSame(['ROLE_FRANZ'], $data['roles']);
    }

    public function testAuthUserNotFound()
    {
        $this->testClient->setUpUser('foobar', symfonyRoles: ['ROLE_XXX']);
        $response = $this->testClient->get('/frontend/users/foobar2');
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
