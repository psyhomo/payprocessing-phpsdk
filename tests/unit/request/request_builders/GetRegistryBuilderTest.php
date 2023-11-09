<?php

namespace Platron\PhpSdk\tests\unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\GetRegistryBuilder;

class GetRegistryBuilderTest extends TestCase {

	public function testExecute() {
		$requestBuilder = new GetRegistryBuilder(new DateTime('2016-01-01'));
		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('2016-01-01', $requestBuilderParameters['pg_date']);
	}
}
