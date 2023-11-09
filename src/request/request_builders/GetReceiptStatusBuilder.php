<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для получения статуса чека
 */
class GetReceiptStatusBuilder extends RequestBuilder {

	/** @var int */
	protected int $pg_receipt_id;


	/**
	 * @param int $receiptId
	 */
	public function __construct(int $receiptId) {
		$this->pg_receipt_id = $receiptId;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'get_receipt_status.php';
	}
}