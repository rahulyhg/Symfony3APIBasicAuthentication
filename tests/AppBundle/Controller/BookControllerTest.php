<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class BookControllerTest extends WebTestCase
{
	protected function setUp()
    {
        $mock = new MockHandler([new Response(200, [])]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
	    // or
	 /*  $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'headers' => [
                'Accept' => 'application/json; charset=utf-8'
            ]
        ]);*/
    }

    public function testGetBooks()
    {
        $response = $this->client->get('/api/books', [
            'auth' => [
            	'tony',
				'123456'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetBook()
    {
        $response = $this->client->get('/api/books/1', [
            'auth' => [
            	'tony',
				'123456'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostBook()
    {
        $response = $this->client->post('/api/books', [
            'auth' => [
                'tony',
				'123456'
            ],
            'json' => [
                'name'     => 'Foo bar',
                'price'  => '19.99'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPutBook()
    {
        $response = $this->client->put('/api/books/2', [
            'auth' => [
                'tony',
				'123456'
            ],
            'json' => [
                'name'     => 'Foo bar',
                'price'  => '19.99'
            ]
    	]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteBook()
    {
        $response = $this->client->delete('/api/books/3', [
            'auth' => [
                'tony',
				'123456'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
