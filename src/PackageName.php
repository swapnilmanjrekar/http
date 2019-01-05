<?php


namespace calderawp\caldera\Http;

use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\caldera\Http\Contracts\HttpContract;

class Http extends Module implements HttpContract
{
	const IDENTIFIER  = 'Http';
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	public function registerServices(ServiceContainer $container): CalderaModule
	{

		return $this;
	}
}
