<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\request_builders\MakeRecurringBuilder;

class MakeRecurringBuilderTest extends TestCase {

	/**
	 * @throws Exception
	 */
	public function testExecute() {

		$requestBuilder = new MakeRecurringBuilder('4321', 'test');

		$requestBuilder->addAmount('10.00')
			->addEncoding('UTF8')
			->addMerchantParams(['merchant_param' => 'test'])
			->addOrderId('777944')
			->addRefundUrl('www.test.ru/refund.php')
			->addRequestMethod('POST')
			->addResultUrl('www.test.ru/result.php');

		$requestBuilderParameters = $requestBuilder->getParameters();

		$this->assertEquals('4321', $requestBuilderParameters['pg_recurring_profile']);
		$this->assertEquals('test', $requestBuilderParameters['pg_description']);

		$this->assertEquals('10.00', $requestBuilderParameters['pg_amount']);
		$this->assertEquals('UTF8', $requestBuilderParameters['pg_encoding']);
		$this->assertEquals('test', $requestBuilderParameters['merchant_param']);
		$this->assertEquals('777944', $requestBuilderParameters['pg_order_id']);
		$this->assertEquals('www.test.ru/refund.php', $requestBuilderParameters['pg_refund_url']);
		$this->assertEquals('POST', $requestBuilderParameters['pg_request_method']);
		$this->assertEquals('www.test.ru/result.php', $requestBuilderParameters['pg_result_url']);
	}


	public function testExecuteMerchantParamsException() {

		$requestBuilder = new MakeRecurringBuilder('4321', 'test');

		try {
			$requestBuilder->addMerchantParams(['pg_merchant_param' => 'test']);
		} catch (Exception) {
			return true;
		}

		return false;
	}
}
