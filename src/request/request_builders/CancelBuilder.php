<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для отмены транзакции, которая еще не была оплачена
 */
class CancelBuilder extends RequestBuilder {

	/** @var int $payment */
	protected int $pg_payment_id;


	/**
	 * @param int $payment
	 */
	public function __construct(int $payment) {
		$this->pg_payment_id = $payment;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'cancel.php';
	}

}
