<?php

namespace Platron\PhpSdk\tests\integration;

use PHPUnit\Framework\TestCase;

abstract class IntegrationTestBase extends TestCase {

	/** @var int */
	protected int $merchantId;

	/** @var string */
	protected string $secretKey;


	public function setUp(): void {
		$this->merchantId = MerchantSettings::MERCHANT_ID;
		$this->secretKey = MerchantSettings::SECRET_KEY;
	}
}
