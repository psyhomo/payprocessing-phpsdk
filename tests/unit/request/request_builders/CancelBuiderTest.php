<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\CancelBuilder;

class CancelBuilderTest extends TestCase {

	public function testExecute() {
		$requestBuilder = new CancelBuilder('363654');
		$requestBuilderParameters = $requestBuilder->getParameters();
		$this->assertEquals('363654', $requestBuilderParameters['pg_payment_id']);
	}
}
