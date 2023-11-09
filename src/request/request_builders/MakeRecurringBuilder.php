<?php

namespace Platron\PhpSdk\request\request_builders;

use Platron\PhpSdk\Exception;

/**
 * Строитель для создании транзакции по рекуррентному платежу. Рекуррентные платежи нужно согласовать с менеджером
 */
class MakeRecurringBuilder extends RequestBuilder {

	/** @var int Id рекурретного профиля */
	protected int $pg_recurring_profile;

	/** @var string Описание платежа */
	protected string $pg_description;

	/** @var string Номер заказа магазина */
	protected string $pg_order_id;

	/** @var float Сумма */
	protected float $pg_amount;

	/** @var string Result Url */
	protected string $pg_result_url;

	/** @var string Refund Url */
	protected string $pg_refund_url;

	/** @var string Метод запросов */
	protected string $pg_request_method;

	/** @var string Кодировка запроса */
	protected string $pg_encoding;

	/** @var string IP адрес пользователя */
	protected string $pg_user_ip;


	/**
	 * @param int $recurringProfile Id рекуррентного платежа
	 * @param string $description Опсиание платежа
	 */
	public function __construct(int $recurringProfile, string $description) {
		$this->pg_recurring_profile = $recurringProfile;
		$this->pg_description = $description;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'make_recurring_payment.php';
	}


	/**
	 * Добавить номер заказа магазина к запросу
	 * @param int $order
	 * @return $this
	 */
	public function addOrderId(int $order): MakeRecurringBuilder {

		$this->pg_order_id = $order;

		return $this;
	}


	/**
	 * Установить сумму. По умолчанию - равно сумме первого платежа
	 * @param float $amount
	 * @return $this
	 */
	public function addAmount(float $amount): self {
		$this->pg_amount = $amount;

		return $this;
	}


	/**
	 * Установить result url в транзакции
	 * @param string $resultUrl
	 * @return $this
	 */
	public function addResultUrl(string $resultUrl): self {
		$this->pg_result_url = $resultUrl;

		return $this;
	}


	/**
	 * Установить refund url в транзакцию
	 * @param string $refundUrl
	 * @return $this
	 */
	public function addRefundUrl(string $refundUrl): self {
		$this->pg_refund_url = $refundUrl;

		return $this;
	}


	/**
	 * Установить метод для запроса в магазин
	 * @param string $reqestMethod
	 * @return $this
	 */
	public function addRequestMethod(string $reqestMethod): self {
		$this->pg_request_method = $reqestMethod;

		return $this;
	}


	/**
	 * Установить кодировку транзакции
	 * @param string $encoding
	 * @return $this
	 */
	public function addEncoding(string $encoding): self {
		$this->pg_encoding = $encoding;

		return $this;
	}


	/**
	 * @param array $params Список дополнительных параметров магазина
	 * @return $this
	 * @throws Exception
	 */
	public function addMerchantParams(array $params): self {

		foreach ($params as $name => $value) {
			if (str_starts_with($name, 'pg_')) {
				throw new Exception('Только параметры без pg_');
			}
			$this->$name = $value;
		}

		return $this;
	}


	/**
	 * @param string $userIp
	 * @return $this
	 */
	public function addUserIp(string $userIp): self {
		$this->pg_user_ip = $userIp;

		return $this;
	}

}
