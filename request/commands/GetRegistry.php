<?php

namespace platron_sdk\request\commands;

/**
 * Команда для получения реестра платежей
 */
class GetRegistry extends BaseCommand {

	/** @var string */
	protected $pg_date;

	/**
	 * @inheritdoc
	 */
	protected function getRequestUrl() {
		return self::PLATRON_URL . 'get_registry.php';
	}

	/**
	 * @param \DateTime $dateTime
	 */
	public function __construct(\DateTime $dateTime) {
		$this->pg_date = $dateTime->format('Y-m-d');
	}

}
