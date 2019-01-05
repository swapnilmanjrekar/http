<?php

namespace calderawp\caldera\Http\Tests;

use calderawp\caldera\Http\Something;

class SomethingTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\Http\Something::hiRoy()
	 */
	public function testHiRoy()
	{
		$this->assertEquals('Hi Roy', (new Something())->hiRoy());
	}
}
