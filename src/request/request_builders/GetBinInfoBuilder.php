<?php

namespace Platron\PhpSdk\request\request_builders;

/**
 * Строитель для получения информации по бину. Для работы с этим запросом необходимо согласование с менеджером
 */
class GetBinInfoBuilder extends RequestBuilder {

	/** @var int Бин карты */
	protected int $pg_bin;


	/**
	 * @param int $bin Бин карты
	 */
	public function __construct(int $bin) {
		$this->pg_bin = $bin;
	}


	/**
	 * @inheritdoc
	 */
	public function getRequestUrl(): string {
		return self::PLATRON_URL . 'get_bin_info.php';
	}

}
