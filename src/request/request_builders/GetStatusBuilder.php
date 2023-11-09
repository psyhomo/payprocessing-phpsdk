<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для получения статуса по транзакции
 */
class GetStatusBuilder extends RequestBuilder {

	/** @var int Id транзакции */
	protected int $pg_payment_id;

	/** @var string|null Order id транзакции у магазина */
	protected ?string $pg_order_id;


	/**
	 * Поиск происходил либо по номеру транзакции в platron, либо по order id магазина
	 * @param int|null $payment Id транзакции
	 * @param string|null $order Order id транзакции в магазине
	 */
	public function __construct(int $payment = null, string $order = null) {
		if ($payment) {
			$this->pg_payment_id = $payment;
		} else {
			$this->pg_order_id = $order;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'get_status.php';
	}

}
