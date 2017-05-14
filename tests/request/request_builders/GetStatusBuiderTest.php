<?php

namespace Platron\PhpSdk\tests;

use Platron\PhpSdk\request\request_builders\GetStatusBuilder;

class GetStatusBuiderTest extends \PHPUnit_Framework_TestCase {
	public function testExecute(){
		$requestBuilder1 = new GetStatusBuilder('34442335');
		$requestBuilderParameters1 = $requestBuilder1->getParameters();
		$this->assertEquals('34442335', $requestBuilderParameters1['pg_payment_id']);
		
		$requestBuilder2 = new GetStatusBuilder(null, '4443');
		$requestBuilderParameters2 = $requestBuilder2->getParameters();
		$this->assertEquals('4443', $requestBuilderParameters2['pg_order_id']);
	}
}