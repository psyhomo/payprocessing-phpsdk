<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для полного / частичного возврата оплаченной транзакции
 */
class RevokeBuilder extends RequestBuilder {

	/** @var int Id платежа */
	protected int $pg_payment_id;

	/** @var float Сумма */
	protected float $pg_refund_amount;


	/**
	 * @param int $payment Id платежа
	 */
	public function __construct(int $payment) {
		$this->pg_payment_id = $payment;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'revoke.php';
	}


	/**
	 * Установка суммы возврата. По умолчанию возвращается вся сумма
	 * @param float $amount
	 */
	public function setAmount(float $amount): void {
		$this->pg_refund_amount = $amount;
	}

}
