<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для создания заявки на возврат. См. поддерживающие ПС в справочнике в документации
 */
class CreateRefundRequestBuilder extends RequestBuilder {

	/** @var int Id Платежа */
	protected int $pg_payment_id;

	/** @var float Сумма заявки на возврат */
	protected float $pg_refund_amount;

	/** @var string Причина возврата */
	protected string $pg_comment;


	/**
	 * @param int $payment Id транзакции
	 * @param float $amount Сумма заявки на возврат
	 * @param string $comment Причина возврата
	 */
	public function __construct(int $payment, float $amount, string $comment) {
		$this->pg_payment_id = $payment;
		$this->pg_refund_amount = $amount;
		$this->pg_comment = $comment;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'create_refund_request.php';
	}

}
