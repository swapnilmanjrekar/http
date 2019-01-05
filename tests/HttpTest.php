<?php

namespace calderawp\caldera\Http\Tests;

use calderawp\caldera\Http\Http;
use calderawp\caldera\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use calderawp\interop\Contracts\HttpResponseContract as ResponseContract;


class HttpTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Http\Http::toPsr7Request()
	 */
	public function testToPsr7Request()
	{
		$headers = [
			'token' => 'sd2a2',
		];
		$params = [
			'entryId' => '1',
			'formId' => 'cf1',
		];
		$request = Request::fromArray([
			'headers' => $headers,
			'params' => $params,
		]);
		$http = new Http($this->core(), $this->serviceContainer());
		$this->assertInstanceOf( RequestInterface::class, $http->toPsr7Request( $request,'https://url.com'));

	}
	/**
	 * @covers \calderawp\caldera\Http\Http::getIdentifier()
	 */
	public function testGetIdentifier()
	{
		$http = new Http($this->core(), $this->serviceContainer());
		$this->assertSame('Http', $http->getIdentifier());
	}

	/**
	 * @covers \calderawp\caldera\Http\Http::send()
	 */
	public function testSend()
	{
		$mockResponse = new Response(200, ['X-Foo' => 'Bar']);
		$mock = new MockHandler([
			$mockResponse
		]);
		$handler = HandlerStack::create($mock);
		$client = new Client(['handler' => $handler]);
		$request = Request::fromArray([
			'headers' => [],
			'params' => [],
		]);
		$http = new Http($this->core(), $this->serviceContainer());
		$http->setClient($client);
		$resonse = $http->send($request,'https://foo.com');
		$this->assertInstanceOf(ResponseContract::class, $resonse );

	}

	/**
	 * @covers \calderawp\caldera\Http\Http::registerServices()
	 * @covers \calderawp\caldera\Http\Http::getClient()
	 */
	public function testRegisterServices()
	{
		$http = new Http($this->core(), $this->serviceContainer());
		$this->assertInstanceOf(ClientInterface::class, $http->getClient() );
	}

	public function testSetClient(){
		$mock = new MockHandler([
			new Response(200, ['X-Foo' => 'Bar']),
		]);
		$handler = HandlerStack::create($mock);
		$client = new Client(['handler' => $handler]);
		$request = Request::fromArray([
			'headers' => [],
			'params' => [],
		]);
		$http = new Http($this->core(), $this->serviceContainer());
		$http->setClient($client);
		$this->assertInstanceOf(ClientInterface::class,$http->getClient());
		$this->assertSame($client,$http->getClient());
	}
}
