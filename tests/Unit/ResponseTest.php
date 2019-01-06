<?php

namespace calderawp\caldera\Http\Tests\Unit;

use calderawp\caldera\Http\Response;

class ResponseTest extends UnitTestCase
{

	/**
	 * @covers \calderawp\caldera\Http\Response::toArray()
	 */
	public function testFromArray()
	{

		$data = [
			'd' => 1,
			'fields' => [[],[]]
		];
		$headers = [
			'X-TOTAL' => 45
		];
		$status = 201;
		$response = Response::fromArray([
			'data' => $data,
			'status' => $status,
			'headers' => $headers
		]);

		$this->assertEquals($headers, $response->getHeaders());
		$this->assertEquals($status, $response->getStatus());
		$this->assertEquals($headers, $response->getHeaders());
	}

	/**
	 * @covers \calderawp\caldera\Http\Response::addHeader()
	 */
	public function testAddHeader()
	{
		$response = new Response();
		$response->addHeader('X-ROY', 'Hi Roy');
		$this->assertAttributeEquals(['X-ROY' => 'Hi Roy'], 'headers', $response);
	}

	/**
	 * @covers \calderawp\caldera\Http\Response::setHttpMethod()
	 * @covers \calderawp\caldera\Http\Response::getHttpMethod()
	 */
	public function testGetSetHttpMethod()
	{
		$response = new Response();
		$response->setHttpMethod('PUT' );
		$this->assertSame('PUT', $response->getHttpMethod());
	}

	/**
	 * @covers \calderawp\caldera\Http\Response::addHeader()
	 */
	public function testAddHeadersViaAddHeader()
	{
		$response = new Response();
		$response->addHeader('X-ROY', 'Hi Roy');
		$this->assertAttributeEquals(['X-ROY' => 'Hi Roy'], 'headers', $response);
		$response->addHeader('X-TOTAL', '1');
		$this->assertAttributeEquals(['X-ROY' => 'Hi Roy', 'X-TOTAL' => '1'], 'headers', $response);
	}
}
