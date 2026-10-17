<?php

declare(strict_types=1);

namespace Gateways;

use Psr\Http\Message\ResponseInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;

final readonly class HelloController
{
	public function __construct(
		private ResponseFactoryInterface $responseFactory,
	) {
	}

	public function hello(): ResponseInterface
	{
		return $this->responseFactory->createResponse(StatusCodeInterface::STATUS_FOUND);
	}
}