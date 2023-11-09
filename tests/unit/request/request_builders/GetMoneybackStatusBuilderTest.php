<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\GetMoneybackStatusBulder;

class GetMoneybackStatusBuilderTest extends TestCase {

	public function testExecute() {
		$requestBuilder = new GetMoneybackStatusBulder('3344');
		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('3344', $requestBuilderParameters['pg_moneyback_id']);
	}
}
