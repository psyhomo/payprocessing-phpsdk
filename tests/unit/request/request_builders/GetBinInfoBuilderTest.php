<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\GetBinInfoBuilder;

class GetBinInfoBuilderTest extends TestCase {

	public function testExecute() {
		$requestBuilder = new GetBinInfoBuilder('444555');
		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('444555', $requestBuilderParameters['pg_bin']);
	}
}
