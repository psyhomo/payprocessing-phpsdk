<?php

namespace Platron\PhpSdk\request\request_builders;

use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\data_objects\AviaGds;
use Platron\PhpSdk\request\data_objects\BankCard;

/**
 * Строитель для создании транзакции
 */
class InitPaymentBuilder extends RequestBuilder {

	/** @var string Для статистики использования SDK */
	protected string $sdk = 'phpsdk';

	/** @var float Сумма транзакции */
	protected float $pg_amount;

	/** @var string Описание транзакции */
	protected string $pg_description;

	/** @var BankCard Данные банковской карты */
	protected BankCard $bankCard;

	/** @var AviaGds Данные по GDS */
	protected AviaGds $aviaGds;

	/** @var string Номер заказа в магазине */
	protected string $pg_order_id;

	/** @var string Валюта транзакции */
	protected string $pg_currency;

	/** @var int Время жизни счета транзакции */
	protected int $pg_lifetime;

	/** @var boolean Отлиженный платеж */
	protected bool $pg_postpone;

	/** @var string Язык транзакции */
	protected string $pg_language;

	/** @var boolean Установлен ли демо режим */
	protected bool $pg_testing_mode;

	/** @var boolean Стартовать ли рекуррентный профиль */
	protected bool $pg_recurring_start;

	/** @var string|array Заранее выбранная платежная система */
	protected string|array $pg_payment_system;

	/** @var string Check url */
	protected string $pg_check_url;

	/** @var string Result url */
	protected string $pg_result_url;

	/** @var string Refund url */
	protected string $pg_refund_url;

	/** @var string Capture url */
	protected string $pg_capture_url;

	/** @var string Request method */
	protected string $pg_request_method;

	/** @var string Success url */
	protected string $pg_success_url;

	/** @var string Success url method */
	protected string $pg_success_url_method;

	/** @var string State url */
	protected string $pg_state_url;

	/** @var string State url method */
	protected string $pg_state_url_method;

	/** @var string Failure url */
	protected string $pg_failure_url;

	/** @var string Failure url method */
	protected string $pg_failure_url_method;

	/** @var string Site url */
	protected string $pg_site_url;

	/** @var string IP клиента в формате long */
	protected string $pg_user_ip;

	/** @var string Email клиента */
	protected string $pg_user_contact_email;

	/** @var string Телефон клиента */
	protected string $pg_user_phone;


	/**
	 * @param float $amount Сумма транзакции
	 * @param string $description Описание транзакции
	 */
	public function __construct(float $amount, string $description) {
		$this->pg_amount = $amount;
		$this->pg_description = $description;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'init_payment.php';
	}


	/**
	 * @inheritdoc
	 */
	public function getParameters(): array {
		$filledvars = [];
		foreach (get_object_vars($this) as $name => $value) {
			if ($value !== null && !in_array($name, ['bankCard', 'aviaGds'])) {
				$filledvars[ $name ] = (string)$value;
			}
		}

		if (!empty($this->aviaGds)) {
			foreach ($this->aviaGds->getParameters() as $name => $value) {
				$filledvars[ $name ] = (string)$value;
			}
		}

		if (!empty($this->bankCard)) {
			foreach ($this->bankCard->getParameters() as $name => $value) {
				$filledvars[ $name ] = (string)$value;
			}
		}

		return $filledvars;
	}


	/**
	 * Уставновить банковскую карту
	 * Внимание! Возможно использование только при наличии у магазина сертификата PSI DSS и при согласовании с менеджером
	 * @param BankCard $bankCard
	 * @return $this
	 */
	public function addBankCard(BankCard $bankCard): self {
		$this->bankCard = $bankCard;

		return $this;
	}


	/**
	 * Установить GDS данные. Используется после согласования с менеджером
	 * @param AviaGds $aviaGds
	 * @return $this
	 */
	public function addGds(AviaGds $aviaGds): self {
		$this->aviaGds = $aviaGds;

		return $this;
	}


	/**
	 * Установить в тарнзакцию платежную систему
	 * @param string|string[] $paymentSystem
	 * @return $this
	 */
	public function addPaymentSystem(array|string $paymentSystem): self {

		$this->pg_payment_system = $paymentSystem;

		return $this;
	}


	/**
	 * Добавить номер заказа магазина
	 * @param string $order
	 * @return $this
	 */
	public function addOrderId(string $order): self {
		$this->pg_order_id = $order;

		return $this;
	}


	/**
	 * Добавить валюту транзакции
	 * @param string $currency
	 * @return $this
	 */
	public function addCurrency(string $currency): self {
		$this->pg_currency = $currency;

		return $this;
	}


	/**
	 * Установить время жизни транзакции
	 * @param int $lifetime
	 * @return $this
	 */
	public function addLifetime(int $lifetime): self {
		$this->pg_lifetime = $lifetime;

		return $this;
	}


	/**
	 * Установить транзакцию как отложенную
	 * @return $this
	 */
	public function addPostpone(): self {
		$this->pg_postpone = 1;

		return $this;
	}


	/**
	 * Установить язык транзакции
	 * @return $this
	 */
	public function addLanguageEn(): self {
		$this->pg_language = 'en';

		return $this;
	}


	/**
	 * Установить демо режим транзакции
	 * @return $this
	 */
	public function addTestingMode(): self {
		$this->pg_testing_mode = 1;

		return $this;
	}


	/**
	 * Установить старт рекуррентной транзакции. Необходимо согласование с магазином
	 * @return $this
	 */
	public function addRecurringStart(): self {
		$this->pg_recurring_start = 1;

		return $this;
	}


	/**
	 * Добавить check url
	 * @param string $url
	 * @return $this
	 */
	public function addCheckUrl(string $url): self {
		$this->pg_check_url = $url;

		return $this;
	}


	/**
	 * Добавить result url
	 * @param string $url
	 * @return $this
	 */
	public function addResultUrl(string $url): self {
		$this->pg_result_url = $url;

		return $this;
	}


	/**
	 * Добавить refund url
	 * @param string $url
	 * @return $this
	 */
	public function addRefundUrl(string $url): self {
		$this->pg_refund_url = $url;

		return $this;
	}


	/**
	 * Добавить capture url
	 * @param string $url
	 * @return $this
	 */
	public function addCaptureUrl(string $url): self {
		$this->pg_capture_url = $url;

		return $this;
	}


	/**
	 * Добавить request метод
	 * @param string $method
	 * @return $this
	 */
	public function addRequestMethod(string $method): self {
		$this->pg_request_method = $method;

		return $this;
	}


	/**
	 * Добавить success url
	 * @param string $url
	 * @return $this
	 */
	public function addSuccessUrl(string $url): self {
		$this->pg_success_url = $url;

		return $this;
	}


	/**
	 * Добавить success url method
	 * @param string $method
	 * @return $this
	 */
	public function addSuccessUrlMethod(string $method): self {
		$this->pg_success_url_method = $method;

		return $this;
	}


	/**
	 * Добавить state url
	 * @param string $url
	 * @return $this
	 */
	public function addStateUrl(string $url): self {
		$this->pg_state_url = $url;

		return $this;
	}


	/**
	 * Добавить state url method
	 * @param string $method
	 * @return $this
	 */
	public function addStateUrlMethod(string $method): self {
		$this->pg_state_url_method = $method;

		return $this;
	}


	/**
	 * Добавить failure url
	 * @param string $url
	 * @return $this
	 */
	public function addFailureUrl(string $url): self {
		$this->pg_failure_url = $url;

		return $this;
	}


	/**
	 * Добавить failure url method
	 * @param string $method
	 * @return $this
	 */
	public function addFailureUrlMethod(string $method): self {
		$this->pg_failure_url_method = $method;

		return $this;
	}


	/**
	 * Добавить site url
	 * @param string $url
	 * @return $this
	 */
	public function addSiteUrl(string $url): self {
		$this->pg_site_url = $url;

		return $this;
	}


	/**
	 * Добавить номер телефона покупателя
	 * @param int $phone
	 * @return $this
	 */
	public function addUserPhone(int $phone): self {
		$this->pg_user_phone = $phone;

		return $this;
	}


	/**
	 * Добавить email покупателя
	 * @param string $email
	 * @return $this
	 */
	public function addUserEmail(string $email): self {
		$this->pg_user_contact_email = $email;

		return $this;
	}


	/**
	 * Добавить ip покупателя в формате long
	 * @param string $ip
	 * @return $this
	 */
	public function addUserIp(string $ip): self {
		$this->pg_user_ip = $ip;

		return $this;
	}


	/**
	 * Установить произвольные поля магазина
	 * @param array $parameters
	 * @return $this
	 * @throws Exception
	 */
	public function addMerchantParams(array $parameters): self {

		foreach ($parameters as $name => $value) {
			if (str_starts_with($name, 'pg_')) {
				throw new Exception('Только параметры без pg_');
			}
			$this->$name = $value;
		}

		return $this;
	}


	/**
	 * Установить дополнительные для ПС параметры (например, для альфаклик идентификатор в интернет банке)
	 * @param array $parameters
	 * @return $this
	 * @throws Exception
	 */
	public function addPsAdditionalParameters(array $parameters): self {

		foreach ($parameters as $name => $value) {
			if (!str_starts_with($name, 'pg_')) {
				throw new Exception('Только параметры с pg_');
			}
			$this->$name = $value;
		}

		return $this;
	}

}
