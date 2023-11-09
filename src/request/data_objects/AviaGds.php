<?php

namespace Platron\PhpSdk\request\data_objects;

class AviaGds extends BaseData {

	/** @var string[] Список брендов карт, принимаемых к оплате */
	protected array $pg_card_brand;

	/** @var string PNR */
	protected string $pg_rec_log;

	/** @var string Название GDS (AMADUS|SABRE|GALILEO и т.д.) */
	protected string $pg_gds;

	/** @var float Сумма надбавки магазина */
	protected float $pg_merchant_markup;


	/**
	 * @param string $recLoc PNR
	 * @param string $gds Название GDS (AMADUS|SABRE|GALILEO и т.д.)
	 * @param float $markup Сумма надбавки магазина
	 */
	public function __construct(string $recLoc, string $gds, float $markup) {
		$this->pg_rec_log = $recLoc;
		$this->pg_gds = $gds;
		$this->pg_merchant_markup = $markup;
	}


	/**
	 * Установить тип карт, по которым принимаем оплату
	 * @param array $cardBrands
	 */
	public function addCardBrands(array $cardBrands): void {
		$this->pg_card_brand = $cardBrands;
	}

}
