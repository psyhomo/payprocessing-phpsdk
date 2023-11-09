<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\CreateRefundRequestBuilder;

class CreateRefundRequestBuilderTest extends TestCase {

	public function testExecute() {
		$requestBuilder = new CreateRefundRequestBuilder('34324324', '10.00', 'test');
		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('34324324', $requestBuilderParameters['pg_payment_id']);
		$this->assertEquals('10.00', $requestBuilderParameters['pg_refund_amount']);
		$this->assertEquals('test', $requestBuilderParameters['pg_comment']);
	}
}
