<?php


namespace calderawp\caldera\Http\Contracts;

use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Contracts\HttpRequestContract as Request;

interface HttpContract extends CalderaModule
{


	public function send(Request $request );
}
