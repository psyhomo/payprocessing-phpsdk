<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\request\request_builders\DoCaptureBuilder;

class DoCaptureBuilderTest extends TestCase {

	public function testExecute() {
		$stubLongRecord = $this->getMockBuilder('Platron\PhpSdk\request\data_objects\LongRecord')->disableOriginalConstructor()->setMethods(['getParameters'])->getMock();
		$stubLongRecord->expects($this->any())->method('getParameters')->willReturn(['long_record_param' => 'test']);

		$requestBuilder = new DoCaptureBuilder('343242');
		$requestBuilder->addLongRecord($stubLongRecord);
		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('343242', $requestBuilderParameters['pg_payment_id']);
		$this->assertEquals('test', $requestBuilderParameters['long_record_param']);
	}
}
