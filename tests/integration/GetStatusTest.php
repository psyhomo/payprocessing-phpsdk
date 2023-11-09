<?php

namespace Platron\PhpSdk\tests\integration;

use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\clients\PostClient;
use Platron\PhpSdk\request\request_builders\GetStatusBuilder;
use Platron\PhpSdk\request\request_builders\InitPaymentBuilder;

/**
 * Интеграционный тест создания транзакции и запроса по ней статуса
 */
class GetStatusTest extends IntegrationTestBase {

	/** @var int */
	protected int $paymentId;

	/** @var PostClient */
	protected PostClient $postClient;


	/**
	 * @throws Exception
	 */
	public function setUp(): void {
		parent::setUp();

		$postClient = new PostClient($this->merchantId, $this->secretKey);
		$this->postClient = $postClient;

		$initPaymentBuilder = new InitPaymentBuilder('10.00', 'test php sdk');
		$this->paymentId = (int)$postClient->request($initPaymentBuilder)->pg_payment_id;
	}


	/**
	 * @throws Exception
	 */
	public function testGetStatus() {
		$getStatusBuilder = new GetStatusBuilder($this->paymentId);
		$getStatusResponse = $this->postClient->request($getStatusBuilder);
		$this->assertEquals('ok', $getStatusResponse->pg_status);
	}
}
