<?php

namespace Platron\PhpSdk\request\request_builders;

class DeleteScheduleBuilder extends RequestBuilder {

	/** @var int */
	protected int $pg_merchant_id;

	/** @var int */
	protected int $pg_recurring_profile;


	/**
	 * GetScheduleBuilder constructor.
	 * @param $merchantId
	 * @param $recurringProfile
	 */
	public function __construct($merchantId, $recurringProfile) {
		$this->pg_merchant_id = $merchantId;
		$this->pg_recurring_profile = $recurringProfile;
	}


	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'index.php/api/recurring/clear-schedule';
	}
}