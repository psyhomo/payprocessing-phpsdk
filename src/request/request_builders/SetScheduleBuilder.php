<?php

namespace Platron\PhpSdk\request\request_builders;

use DateTime;
use Platron\PhpSdk\Exception;

class SetScheduleBuilder extends RequestBuilder {

	const
		INTERVAL_DAY = 'day',
		INTERVAL_WEEK = 'week',
		INTERVAL_MONTH = 'month';

	/** @var int */
	protected int $pg_merchant_id;

	/** @var int */
	protected int $pg_recurring_profile;

	/** @var double */
	protected float $pg_amount;

	/** @var string[] */
	protected array $pg_dates;

	/** @var string|array */
	protected string|array $pg_template;


	/**
	 * SetScheduleBuilder constructor.
	 * @param int $merchantId
	 * @param int $recurringProfile
	 * @param double $amount
	 */
	public function __construct(int $merchantId, int $recurringProfile, float $amount) {
		$this->pg_merchant_id = $merchantId;
		$this->pg_recurring_profile = $recurringProfile;
		$this->pg_amount = $amount;
	}


	/**
	 * @return string
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'index.php/api/recurring/set-schedule';
	}


	/**
	 * @param DateTime $dates
	 */
	public function addDate(DateTime $dates): void {
		$this->pg_dates[] = $dates->format('Y-m-d H:i:s');
	}


	/**
	 * ScheduleTemplate constructor.
	 * @param DateTime $startDate
	 * @param string $interval
	 * @param int $period
	 * @param int|null $maxPeriods
	 * @throws Exception
	 */
	public function addTemplate(DateTime $startDate, string $interval, int $period, int $maxPeriods = null): void {

		if (!in_array($interval, $this->getPossibleIntervals())) {
			throw new Exception('Wrong interval type. Use from constants');
		}

		$this->pg_template['pg_start_date'] = $startDate->format('Y-m-d H:i:s');
		$this->pg_template['pg_interval'] = $interval;
		$this->pg_template['pg_period'] = $period;
		$this->pg_template['pg_max_periods'] = $maxPeriods;
	}


	/**
	 * @return array
	 */
	private function getPossibleIntervals(): array {
		return [
			self::INTERVAL_DAY,
			self::INTERVAL_WEEK,
			self::INTERVAL_MONTH,
		];
	}
}