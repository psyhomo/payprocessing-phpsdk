<?php

namespace Platron\PhpSdk\request\data_objects;

class BankCard extends BaseData {

	/** @var int Номер карты */
	public int $pg_card_number;

	/** @var string Имя на карте */
	public string $pg_user_cardholder;

	/** @var int Год истечения карты */
	public int $pg_exp_year;

	/** @var int Месяц истечения карты */
	public int $pg_exp_month;

	/** @var int CVV */
	public int $pg_cvv2;

	/** @var string IP пользователя в формате long */
	public string $pg_user_ip;


	/**
	 * @param int $cardNumber Номер карты
	 * @param string $cardHolderName Имя на карте
	 * @param int $expYear Год истечения карты
	 * @param int $expMonth Месяц истечения карты
	 * @param int $cvv CVV
	 * @param string $userIp IP пользователя в формате long
	 */
	public function __construct(int $cardNumber, string $cardHolderName, int $expYear, int $expMonth, int $cvv, string $userIp) {
		$this->pg_card_number = $cardNumber;
		$this->pg_user_cardholder = $cardHolderName;
		$this->pg_exp_year = $expYear;
		$this->pg_exp_month = $expMonth;
		$this->pg_cvv2 = $cvv;
		$this->pg_user_ip = $userIp;
	}
}
