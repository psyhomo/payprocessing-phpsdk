<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\request_builders\ReceiptBuilder;

class CreateReceiptBuilderTest extends TestCase {

	/**
	 * @throws Exception
	 */
	public function testGetParameters() {
		$itemStub = $this->getMockBuilder('Platron\PhpSdk\request\data_objects\Item')->disableOriginalConstructor()->setMethods([])->getMock();
		$itemStub->expects($this->any())->method('getParameters')->willReturn(['item_parameter' => 'test']);

		$createReceiptBuilder = new ReceiptBuilder(ReceiptBuilder::TRANSACTION_TYPE, 100500, 100501);
		$result = $createReceiptBuilder->addItem($itemStub);
		$this->assertSame($createReceiptBuilder, $result);

		$parameters = $createReceiptBuilder->getParameters();
		$itemParameters = $parameters['pg_items'][0];

		$this->assertEquals(ReceiptBuilder::TRANSACTION_TYPE, $parameters['pg_operation_type']);
		$this->assertEquals(100500, $parameters['pg_payment_id']);
		$this->assertEquals(100501, $parameters['pg_order_id']);
		$this->assertEquals('test', $itemParameters['item_parameter']);
	}


	public function testExceptionSetOperationType() {

		try {
			new ReceiptBuilder('wrong value', 100500, 100501);
		} catch (Exception) {
			return true;
		}

		return false;
	}


	public function testExceptionEmptyTransactionAndOrder() {
		try {
			new ReceiptBuilder(ReceiptBuilder::TRANSACTION_TYPE);

		} catch (Exception) {
			return true;
		}

		return false;
	}
}
