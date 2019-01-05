<?php


namespace calderawp\caldera\Http\Contracts;

use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Contracts\HttpRequestContract as Request;
use calderawp\interop\Contracts\HttpResponseContract as Response;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\ClientInterface as Client;
use Psr\Http\Message\ResponseInterface;

interface HttpContract extends CalderaModule
{

	/**
	 * Send a request
	 *
	 * @param Request $request
	 * @param string $uri
	 *
	 * @return Response
	 */
	public function send(Request $request, string $uri ) : Response;

	/**
	 * Set the HTTP client
	 *
	 * @param Client $client
	 *
	 * @return HttpContract
	 */
	public function setClient( Client $client ) : HttpContract;

	/**
	 * Get the HTTP client
	 *
	 * @return Client
	 */
	public function getClient() : Client;

	/**
	 * Convert Caldera/HttpRequestContract to to PSR-7 request object
	 *
	 * @param Request $request
	 * @param null|string $uri
	 *
	 * @return RequestInterface
	 */
	public function toPsr7Request(Request $request, ?string $uri = null): RequestInterface;

	/**
	 * Convert PSR-7 response object to Caldera/HttpResponseContract
	 *
	 * @param ResponseInterface $response
	 *
	 * @return Response
	 */
	public function fromPsr7Response( ResponseInterface $response) : Response;
}
