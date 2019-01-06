<?php


namespace calderawp\caldera\Http;

use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Contracts\HttpRequestContract as Request;
use calderawp\interop\Contracts\HttpResponseContract as Response;
use calderawp\interop\Module;
use calderawp\caldera\Http\Contracts\CalderaHttpContract;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as Client;
use Psr\Http\Message\ResponseInterface;

class CalderaHttp extends Module implements CalderaHttpContract
{
	const IDENTIFIER = 'Http';

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	public function registerServices(ServiceContainer $container): CalderaModule
	{

		$this->getServiceContainer()->bind(Client::class, (function () {
			return new \GuzzleHttp\Client([

			]);
		}));
		return $this;
	}

	/** @inheritdoc */
	public function send(Request $request, string $uri): Response
	{

		$request = $this->toPsr7Request($request, $uri);
		$client = $this->getClient();
		$response = $client->send($request);
		return $this->fromPsr7Response($response);
	}

	/** @inheritdoc */
	public function toPsr7Request(Request $request, ?string $uri = null): RequestInterface
	{
		return new \GuzzleHttp\Psr7\Request(
			$request->getHttpMethod(),
			$uri,
			$request->getHeaders(),
			json_encode($request)
		);
	}

	/** @inheritdoc */
	public function fromPsr7Response(ResponseInterface $response): Response
	{
		$_response = new \calderawp\caldera\Http\Response();
		$_response->setHeaders($response->getHeaders());
		$_response->setStatus($response->getStatusCode());
		$body = json_decode($response->getBody(), true);
		if (is_array($body)) {
			$_response->setData($body);
		}
		return $_response;
	}

	/** @inheritdoc */
	public function setClient(Client $client): CalderaHttpContract
	{
		$this->client = $client;
		return $this;
	}

	/** @inheritdoc */
	public function getClient(): Client
	{
		if (is_a($this->client, Client::class)) {
			return $this->client;
		}
		return $this->getServiceContainer()->make(Client::class);
	}
}
