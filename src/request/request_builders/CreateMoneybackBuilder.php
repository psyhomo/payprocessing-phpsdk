<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для создания выплаты. Может быть связана с платежной транзакцией
 */
class CreateMoneybackBuilder extends RequestBuilder {

	/** @var int Id договора */
	protected int $pg_contract_id;

	/** @var string Название системы выплат */
	protected string $pg_moneyback_system;

	/** @var float Сумма */
	protected float $pg_amount;

	/** @var string Описание */
	protected string $pg_description;

	/** @var int $transaction Id транзакции */
	protected int $pg_payment_id;


	/**
	 * @param int $contract Id договора (можно получить из GetMoneybackList)
	 * @param string $moneybackSystem Название системы выплат
	 * @param float $amount Сумма выплаты
	 * @param string $description Описание выплаты
	 * @param array $additionalParams Дополнительные параметры, необходимые для системы выплат (можно получить из
	 *   GetMoneybackList)
	 */
	public function __construct(int $contract, string $moneybackSystem, float $amount, string $description, array $additionalParams) {

		$this->pg_contract_id = $contract;
		$this->pg_moneyback_system = $moneybackSystem;
		$this->pg_amount = $amount;
		$this->pg_description = $description;

		foreach ($additionalParams as $name => $param) {
			$this->$name = $param;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'create_moneyback.php';
	}


	/**
	 * Привязать выплату к транзакции
	 * @param int $payment Id транзакции
	 */
	public function bindToTransaction(int $payment): void {
		$this->pg_payment_id = $payment;
	}

}
