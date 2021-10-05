<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Dbp\Relay\CoreBundle\TestUtils\UserAuthTrait;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends ApiTestCase
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

    public function testAuthCollection()
    {
        $client = $this->withUser('foobar', [], '42');
        $response = $client->request('GET', '/frontend/users', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = $response->getContent();
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        $this->assertNotNull($data);
    }

    public function testAuthUser()
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

    public function testAuthUserNotFound()
    {
        $client = $this->withUser('foobar', ['ROLE_XXX'], '42');
        $response = $client->request('GET', '/frontend/users/foobar2', ['headers' => [
            'Authorization' => 'Bearer 42',
        ]]);
        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
