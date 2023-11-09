<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для получения статуса выплаты
 */
class GetMoneybackStatusBulder extends RequestBuilder {

	/** @var int $pg_moneyback_id */
	protected int $pg_moneyback_id;


	/**
	 * @param int $moneyback Id манибека
	 */
	public function __construct(int $moneyback) {
		$this->pg_moneyback_id = $moneyback;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'get_moneyback_status.php';
	}

}
