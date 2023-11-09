<?php

namespace Platron\PhpSdk\tests\integration;

use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\request_builders\DoCaptureBuilder;
use Platron\PhpSdk\request\request_builders\InitPaymentBuilder;

/*
 * Интеграционный тест создания и клиринга транзакции
 */

class DoCaptureTest extends PaidTransactionTestBase {

	/** @var int */
	protected $paymentId;


	public function getInitPaymentBuilder(): InitPaymentBuilder {
		$factory = new InitPaymentBuilderFactory();

		return $factory->createForTestCardPaymentSystem();
	}


	/**
	 * @throws Exception
	 */
	public function testCapture() {
		$doCaptureBuilder = new DoCaptureBuilder($this->paymentId);
		$captureResponse = $this->postClient->request($doCaptureBuilder);
		$this->assertEquals('ok', $captureResponse->pg_status);
	}
}