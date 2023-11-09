<?php

namespace Platron\PhpSdk\tests\integration;

use Platron\PhpSdk\request\data_objects\BankCard;
use Platron\PhpSdk\request\request_builders\InitPaymentBuilder;

class InitPaymentBuilderFactory {

	const PHONE = 79009999999;
	const PAN = 4257000000000002;
	const HOLDER_NAME = 'TEST';
	const EXPIRE_YEAR = 2025;
	const EXPIRE_MONTH = 01;
	const CVV = 800;
	const USER_IP = '185.76.252.5';


	public function createForTestCardPaymentSystem(): InitPaymentBuilder {
		$initPaymentBuilder = new InitPaymentBuilder('10.00', 'test php sdk');
		$initPaymentBuilder->addUserPhone(static::PHONE)
			->addTestingMode()
			->addPaymentSystem('TESTCARD')
			->addBankCard(
				new BankCard(static::PAN,
					static::HOLDER_NAME,
					static::EXPIRE_YEAR,
					static::EXPIRE_MONTH,
					static::CVV,
					static::USER_IP)
			);

		return $initPaymentBuilder;
	}
}