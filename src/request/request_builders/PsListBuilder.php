<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для получения списка доступных платежных систем и расчета итоговой стоимости
 */
class PsListBuilder extends RequestBuilder {

	/** @var float Сумма */
	protected float $pg_amount;

	/** @var string Валюта */
	protected string $pg_currency;

	/** @var bool Тестовый режим */
	protected bool $pg_testing_mode;


	/**
	 * @param float $amount Сумма для расчета стоимости по каждой ПС
	 */
	public function __construct(float $amount) {
		$this->pg_amount = $amount;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'ps_list.php';
	}


	/**
	 * Установить в запрос валюту. По умолчанию - рубли
	 * @param string $currency
	 * @return $this
	 */
	public function addCurrency(string $currency): PsListBuilder {
		$this->pg_currency = $currency;

		return $this;
	}


	/**
	 * Установить тестовый режим в запрос
	 * @return $this
	 */
	public function addTestingMode(): PsListBuilder {
		$this->pg_testing_mode = 1;

		return $this;
	}

}
