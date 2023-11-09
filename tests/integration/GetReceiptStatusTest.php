<?php

namespace Platron\PhpSdk\tests\integration;

use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\clients\PostClient;
use Platron\PhpSdk\request\data_objects\Item;
use Platron\PhpSdk\request\request_builders\GetReceiptStatusBuilder;
use Platron\PhpSdk\request\request_builders\InitPaymentBuilder;
use Platron\PhpSdk\request\request_builders\ReceiptBuilder;
use SimpleXMLElement;

class GetReceiptStatusTest extends IntegrationTestBase {

	/** @var int|SimpleXMLElement */
	protected int|SimpleXMLElement $receiptId;

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
		$initPaymentBuilder->addTestingMode();
		$paymentId = (int)$postClient->request($initPaymentBuilder)->pg_payment_id;

		$item = new Item('Test product', 10.00, 1);
		$item->addAmount(10.00);

		$createReceiptBuilder = new ReceiptBuilder(ReceiptBuilder::TRANSACTION_TYPE, $paymentId);
		$createReceiptBuilder->addItem($item);
		$createReceiptResponse = $this->postClient->request($createReceiptBuilder);
		$this->receiptId = $createReceiptResponse->pg_receipt_id;
	}


	/**
	 * @throws Exception
	 */
	public function testCreateReceipt() {
		$getReceiptStatusBuilder = new GetReceiptStatusBuilder($this->receiptId);
		$getStatusReceiptResponse = $this->postClient->request($getReceiptStatusBuilder);
		$this->assertEquals('ok', $getStatusReceiptResponse->pg_status);
	}
}