<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\RevokeBuilder;

class RevokeBuilderTest extends TestCase {

	public function testExecute() {
		$requestBuilder = new RevokeBuilder('3444223');
		$requestBuilder->setAmount('10.00');
		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('3444223', $requestBuilderParameters['pg_payment_id']);
		$this->assertEquals('10.00', $requestBuilderParameters['pg_refund_amount']);
	}
}
