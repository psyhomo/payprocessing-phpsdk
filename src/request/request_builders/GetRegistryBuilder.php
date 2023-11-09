<?php

namespace Platron\PhpSdk\request\request_builders;

use DateTime;

/**
 * Строитель для получения реестра платежей
 */
class GetRegistryBuilder extends RequestBuilder {

	/** @var string */
	protected string $pg_date;


	/**
	 * @param DateTime $dateTime
	 */
	public function __construct(DateTime $dateTime) {
		$this->pg_date = $dateTime->format('Y-m-d');
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'get_registry.php';
	}

}
