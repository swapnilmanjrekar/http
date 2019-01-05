<?php

namespace calderawp\caldera\Http\Tests;

use calderawp\caldera\Http\Request;

class RequestTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Http\Request::fromArray()
	 */
	public function testFromArray()
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
		$this->assertEquals($headers[ 'token' ], $request->getHeader('token'));
		$this->assertEquals($params, $request->getParams());
	}
}
