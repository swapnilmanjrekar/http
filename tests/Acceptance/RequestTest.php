<?php


namespace calderawp\caldera\Http\Tests\Acceptance;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use calderawp\caldera\Http\CalderaHttp;
use calderawp\caldera\Http\Request;
use calderawp\interop\Contracts\HttpResponseContract as ResponseContract;

class RequestTest extends AcceptanceTestCase
{

	/**
	 * Ensure that test suite is able to access internet
	 */
	public function testCanInternet()
	{
		$opts = array(
			'http'=>array(
				'method'=>"GET",
			)
		);

		$context = stream_context_create($opts);

		//False on error, resource on success
		$fp = fopen('https://www.ethereum.org/', 'r', false, $context);
		$this->assertNotFalse($fp, 'Unable to reach ethereum.org. Likely means that internet access is not available.');
	}

	/**
	 * Ensure that test suite is able to access our API Server
	 */
	public function testCanRequestApiServer()
	{
		$opts = array(
			'http'=>array(
				'method'=>"GET",
			)
		);

		$context = stream_context_create($opts);

		$url = 'http://localhost:5000/caldera-api/v2/roy';
		//False on error, resource on success
		$fp = fopen($url, 'r', false, $context);
		$this->assertNotFalse($fp, "Unable to reach $url. Most likely this means you did not run yarn start:server before starting tests.");
	}


	/**
	 * @covers \calderawp\caldera\Http\CalderaHttp::send()
	 * @covers \calderawp\caldera\Http\CalderaHttp::fromPsr7Response()
	 */
	public function testSend()
	{
		$url = 'http://localhost:5000/caldera-api/v2/roy';
		$request = Request::fromArray([
			'headers' => [],
			'params' => [],
		]);
		$http = new CalderaHttp($this->core(), $this->serviceContainer());
		$response = $http->send($request, $url);
		$this->assertSame(200, $response->getStatus());
		$this->assertArrayHasKey('Content-Length', $response->getHeaders());
		$this->assertArrayHasKey('Content-Type', $response->getHeaders());
		$this->assertArrayHasKey('blog', $response->getData());
		$this->assertArrayHasKey('location', $response->getData());
	}
}
