<?php

namespace Platron\PhpSdk\request\request_builders;

use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\data_objects\Item;

class ReceiptBuilder extends RequestBuilder {

	const
		ADDITIONAL_PAYMENT_PREPAYMENT = 'prepayment',
		ADDITIONAL_PAYMENT_CREDIT = 'credit';

	const
		TRANSACTION_TYPE = 'payment',
		REFUND_TYPE = 'refund',
		MONEYBACK_TYPE = 'moneyback';

	/** @var string */
	protected string $pg_operation_type;

	/** @var int|null */
	protected ?int $pg_payment_id;

	/** @var string|null */
	protected ?string $pg_order_id;

	/** @var Item[] */
	protected array $items;

	/** @var double */
	protected float $pg_additional_payment_amount;

	/** @var string */
	protected string $pg_additional_payment_type;

	/** @var string */
	protected string $pg_customer_name;

	/** @var int */
	protected int $pg_customer_inn;


	/**
	 * Обязательно одно из двух полей - $paymentId или $orderId
	 * @param string $operationType Чек к какому типу операции. Из констант
	 * @param int|null $paymentId
	 * @param string|null $orderId
	 * @throws Exception
	 */
	public function __construct(string $operationType, int $paymentId = null, string $orderId = null) {

		if (!in_array($operationType, $this->getPossibleOperationTypes())) {
			throw new Exception('Wrong operation type. Use constants');
		}

		if (!$paymentId && !$orderId) {
			throw new Exception('payment id or order id must be not null');
		}

		$this->pg_operation_type = $operationType;
		$this->pg_payment_id = $paymentId;
		$this->pg_order_id = $orderId;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'receipt.php';
	}


	/**
	 * Добавить позицию чека
	 * @param Item $item
	 * @return $this
	 */
	public function addItem(Item $item): self {
		$this->items[] = $item;

		return $this;
	}


	/**
	 * Добавить оплату, которая не проходила через platron
	 * @param string $type
	 * @param double $amount
	 * @throws Exception
	 */
	public function addAdditionalPayment(string $type, float $amount): void {

		if (!in_array($type, $this->getAdditionalPaymentTypes())) {
			throw new Exception('Wrong additional payment type. Use from constant');
		}

		$this->pg_additional_payment_type = $type;
		$this->pg_additional_payment_amount = $amount;
	}


	/**
	 * Добавить данные покупателя
	 * @param string $name
	 * @param int $inn
	 */
	public function addCustomer(string $name, int $inn): void {
		$this->pg_customer_name = $name;
		$this->pg_customer_inn = $inn;
	}


	/**
	 * @inheritdoc
	 */
	public function getParameters(): array {
		$filledvars = [];

		foreach (get_object_vars($this) as $name => $value) {

			if ($value !== null && $name != 'items') {
				$filledvars[ $name ] = (string)$value;
			}
		}

		foreach ($this->items as $item) {
			$filledvars['pg_items'][] = $item->getParameters();
		}

		return $filledvars;
	}


	/**
	 * Получить возможные варианты операций
	 * @return array
	 */
	private function getPossibleOperationTypes(): array {
		return [
			self::TRANSACTION_TYPE,
			self::REFUND_TYPE,
			self::MONEYBACK_TYPE,
		];
	}


	/**
	 * Получить возможные типы дополнительных оплат не через Платрон
	 * @return array
	 */
	private function getAdditionalPaymentTypes(): array {
		return [
			self::ADDITIONAL_PAYMENT_PREPAYMENT,
			self::ADDITIONAL_PAYMENT_CREDIT,
		];
	}
}
