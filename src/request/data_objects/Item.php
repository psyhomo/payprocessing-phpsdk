<?php

namespace Platron\PhpSdk\request\data_objects;

use Platron\PhpSdk\Exception;

class Item extends BaseData {
	const
		TYPE_PRODUCT = 'product',
		TYPE_PRODUCT_EXCISE = 'product_excise',
		TYPE_WORK = 'work',
		TYPE_SERVICE = 'service',
		TYPE_GAMBLING_BET = 'gambling_bet',
		TYPE_GAMBLING_WIN = 'gambling_win',
		TYPE_LOTTERY_BET = 'lottery_bet',
		TYPE_LOTTERY_WIN = 'lottery_win',
		TYPE_RID = 'rid',
		TYPE_PAYMENT = 'payment',
		TYPE_COMMISSION = 'commission',
		TYPE_COMPOSITE = 'composite',
		TYPE_OTHER = 'other';

	const
		VAT0 = '0', // 0%
		VAT10 = '10', // 10%
		VAT20 = '20', // 20%
		VAT110 = '110', // формула 10/110
		VAT120 = '120'; // формула 20/120

	const
		PAYMENT_FULL_PAYMENT = 'full_payment',
		PAYMENT_PRE_PAYMENT_FULL = 'pre_payment_full',
		PAYMENT_PRE_PAYMENT_PART = 'pre_payment_part',
		PAYMENT_ADVANCE = 'advance',
		PAYMENT_CREDIT_PART = 'credit_part',
		PAYMENT_CREDIT_PAY = 'credit_pay',
		PAYMENT_CREDIT = 'credit';

	const
		AGENT_TYPE_COMMISSIONAIRE = 'commissionaire',
		AGENT_TYPE_BANK_PAYMENT_AGENT = 'bank_payment_agent',
		AGENT_TYPE_BANK_PAYMENT_SUBAGENT = 'bank_payment_subagent',
		AGENT_TYPE_PAYMENT_AGENT = 'payment_agent',
		AGENT_TYPE_PAYMENT_SUBAGENT = 'payment_subagent',
		AGENT_TYPE_AGENT = 'agent',
		AGENT_TYPE_SOLICITOR = 'solicitor';

	/** @var string */
	protected string $pg_label;

	/** @var float */
	protected float $pg_amount;

	/** @var float */
	protected float $pg_price;

	/** @var int */
	protected int $pg_quantity;

	/** @var string|null */
	protected ?string $pg_vat;

	/** @var string */
	protected string $pg_type = 'product';

	/** @var string */
	protected string $pg_nomenclature_code;

	/** @var string */
	protected string $pg_payment_type;

	/** @var string */
	protected string $pg_agent_type;

	/** @var string */
	protected string $pg_agent_name;

	/** @var int */
	protected int $pg_agent_inn;

	/** @var int */
	protected int $pg_agent_phone;


	/**
	 * @param string $label Название товара
	 * @param float $price Цена единицы товара
	 * @param int $quantity Количество
	 * @param string|null $vat Если отсутствует - не облягается налогом. Берется из констант
	 * @throws Exception
	 */
	public function __construct(string $label, float $price, int $quantity, string $vat = null) {

		if (!is_null($vat) && !in_array($vat, $this->getVatTypes())) {
			throw new Exception('Wrong vat. Use from constant');
		}

		$this->pg_label = $label;
		$this->pg_quantity = $quantity;
		$this->pg_price = $price;
		$this->pg_vat = $vat;
	}


	/**
	 * Добавить сумму к позиции. Не обязательно. Если сумма меньше количества * стоимость воспринимается как скидка
	 * @param float $amount
	 */
	public function addAmount(float $amount): void {
		$this->pg_amount = $amount;
	}


	/**
	 * Добавить тип товара
	 * @param string $type
	 * @throws Exception
	 */
	public function addType(string $type): void {
		if (!in_array($type, $this->getTypes())) {
			throw new Exception('Wrong type. Use type from constant');
		}

		$this->pg_type = $type;
	}


	/**
	 * Добавить маркировку товара
	 * @param string $nomenclatureCode
	 */
	public function addNomenclatureCode(string $nomenclatureCode): void {
		$this->pg_nomenclature_code = $nomenclatureCode;
	}


	/**
	 * Добавить тип товара
	 * @param string $type
	 * @throws Exception
	 */
	public function addPaymentType(string $type): void {

		if (!in_array($type, $this->getPaymentTypes())) {
			throw new Exception('Wrong payment type. Use payment type from constant');
		}

		$this->pg_payment_type = $type;
	}


	/**
	 * @param string $type
	 * @param string $name
	 * @param int $inn
	 * @param int $phone
	 * @throws Exception
	 */
	public function addAgent(string $type, string $name, int $inn, int $phone): void {

		if (!in_array($type, $this->getAgentTypes())) {
			throw new Exception('Wrong agent type. Use agent type from constant');
		}

		$this->pg_agent_type = $type;
		$this->pg_agent_name = $name;
		$this->pg_agent_inn = $inn;
		$this->pg_agent_phone = $phone;
	}


	/**
	 * Получить возможные варианты НДС
	 * @return array
	 */
	private function getVatTypes(): array {
		return [
			self::VAT0,
			self::VAT10,
			self::VAT110,
			self::VAT120,
			self::VAT20,
		];
	}


	/**
	 * @return array
	 */
	private function getTypes(): array {
		return [
			self::TYPE_PRODUCT,
			self::TYPE_PRODUCT_EXCISE,
			self::TYPE_WORK,
			self::TYPE_SERVICE,
			self::TYPE_GAMBLING_BET,
			self::TYPE_GAMBLING_WIN,
			self::TYPE_LOTTERY_BET,
			self::TYPE_LOTTERY_WIN,
			self::TYPE_RID,
			self::TYPE_PAYMENT,
			self::TYPE_COMMISSION,
			self::TYPE_COMPOSITE,
			self::TYPE_OTHER,
		];
	}


	/**
	 * @return array
	 */
	private function getPaymentTypes(): array {
		return [
			self::PAYMENT_FULL_PAYMENT,
			self::PAYMENT_PRE_PAYMENT_FULL,
			self::PAYMENT_PRE_PAYMENT_PART,
			self::PAYMENT_ADVANCE,
			self::PAYMENT_CREDIT_PART,
			self::PAYMENT_CREDIT_PAY,
			self::PAYMENT_CREDIT,
		];
	}


	/**
	 * @return array
	 */
	private function getAgentTypes(): array {
		return [
			self::AGENT_TYPE_COMMISSIONAIRE,
			self::AGENT_TYPE_BANK_PAYMENT_AGENT,
			self::AGENT_TYPE_BANK_PAYMENT_SUBAGENT,
			self::AGENT_TYPE_PAYMENT_AGENT,
			self::AGENT_TYPE_PAYMENT_SUBAGENT,
			self::AGENT_TYPE_AGENT,
			self::AGENT_TYPE_SOLICITOR,
		];
	}
}
