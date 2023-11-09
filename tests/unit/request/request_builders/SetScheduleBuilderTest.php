<?php

namespace Platron\PhpSdk\tests\unit\request\request_builders;

use DateTime;
use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\request_builders\SetScheduleBuilder;

class SetScheduleBuilderTest extends TestCase {

	public function testGetParametersWithDates() {
		$merchantId = '82';
		$recurringProfile = '231231';
		$amount = '10.00';

		$templateRequest = new SetScheduleBuilder($merchantId, $recurringProfile, $amount);
		$date = new DateTime('2020-01-01 00:00:00');
		$templateRequest->addDate($date);
		$parameters = $templateRequest->getParameters();
		$this->assertEquals($merchantId, $parameters['pg_merchant_id']);
		$this->assertEquals($recurringProfile, $parameters['pg_recurring_profile']);
		$this->assertEquals($amount, $parameters['pg_amount']);
		$this->assertEquals($date->format('Y-m-d H:i:s'), $parameters['pg_dates'][0]);
	}


	/**
	 * @throws Exception
	 */
	public function testGetParametersWithTemplate() {

		$startDate = new DateTime('2020-01-01 00:00:00');
		$period = 10;
		$maxPeriods = 10;

		$templateRequest = new SetScheduleBuilder('82', '231231', '10.00');
		$templateRequest->addTemplate($startDate, SetScheduleBuilder::INTERVAL_WEEK, $period, $maxPeriods);
		$parameters = $templateRequest->getParameters();
		$this->assertEquals($startDate->format('Y-m-d H:i:s'), $parameters['pg_template']['pg_start_date']);
		$this->assertEquals(SetScheduleBuilder::INTERVAL_WEEK, $parameters['pg_template']['pg_interval']);
		$this->assertEquals($period, $parameters['pg_template']['pg_period']);
		$this->assertEquals($maxPeriods, $parameters['pg_template']['pg_max_periods']);
	}
}