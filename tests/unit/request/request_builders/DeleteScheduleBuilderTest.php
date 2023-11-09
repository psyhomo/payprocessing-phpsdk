<?php

namespace Platron\PhpSdk\tests\unit\request\request_builders;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\DeleteScheduleBuilder;

class DeleteScheduleBuilderTest extends TestCase {

	public function testGetParameters() {
		$merchantId = 82;
		$profileId = 12345;
		$deleteBuilder = new DeleteScheduleBuilder($merchantId, $profileId);
		$parameters = $deleteBuilder->getParameters();

		$this->assertEquals($merchantId, $parameters['pg_merchant_id']);
		$this->assertEquals($profileId, $parameters['pg_recurring_profile']);
	}
}