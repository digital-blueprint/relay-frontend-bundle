<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Tests;

use Dbp\Relay\CoreBundle\TestUtils\AbstractApiTest;
use Dbp\Relay\CoreBundle\TestUtils\UserAuthTrait;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends AbstractApiTest
{
    use UserAuthTrait;

    public function testBasics()
    {
        $client = self::createClient();
        $response = $client->request('GET', '/frontend/users');
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());

        $response = $client->request('GET', '/frontend/users/foobar');
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testPostPut()
    {
        $client = self::createClient();
        $response = $client->request('POST', '/frontend/users');
        $this->assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());

        $response = $client->request('PUT', '/frontend/users');
        $this->assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
    }

    public function testAuthCollection()
    {
        $client = $this->withUser('foobar', ['ROLE_XXX'], '42');
        $response = $client->request('GET', '/frontend/users', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
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
        $client = $this->withUser('foobar', [], '42');
        $response = $client->request('GET', '/frontend/users/foobar', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/foobar', $data['@id']);
        $this->assertSame([], $data['roles']);
    }

    public function testAuthUserWithSymfonyRole()
    {
        $client = $this->withUser('foobar', ['ROLE_XXX'], '42');
        $response = $client->request('GET', '/frontend/users/foobar', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/foobar', $data['@id']);
        $this->assertSame(['ROLE_XXX'], $data['roles']);
    }

    public function testAuthUserWithSymfonyRoleAndAddedRole()
    {
        $client = $this->withUser('admin', ['ROLE_XXX'], '42');
        $response = $client->request('GET', '/frontend/users/admin', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
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
        $client = $this->withUser('franz', [], '42');
        $response = $client->request('GET', '/frontend/users/franz', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('/frontend/users/franz', $data['@id']);
        $this->assertSame(['ROLE_FRANZ'], $data['roles']);
    }

    public function testAuthUserNotFound()
    {
        $client = $this->withUser('foobar', ['ROLE_XXX'], '42');
        $response = $client->request('GET', '/frontend/users/foobar2', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
