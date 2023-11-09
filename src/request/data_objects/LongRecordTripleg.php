<?php

namespace Platron\PhpSdk\request\data_objects;

class LongRecordTripleg extends BaseData {

	/**
	 * @param int $triplegNumber Номер шага
	 * @param string $date Дата полета
	 * @param string $carrier Перевозчик
	 * @param string $class Класс перевозки
	 * @param string $destFrom Аэропорт вылета
	 * @param string $destTo Аэропорт прилета
	 * @param string $stopOver Можно ли делать остановку
	 * @param string $basisCode Код тарифа
	 * @param string $flightNumber Номер рейса
	 */
	public function __construct(int    $triplegNumber, string $date, string $carrier, string $class, string $destFrom,
	                            string $destTo, string $stopOver, string $basisCode, string $flightNumber) {
		$dateParamName = 'pg_tripleg_' . $triplegNumber . '_date';
		$this->$dateParamName = $date;

		$carrierName = 'pg_tripleg_' . $triplegNumber . '_carrier';
		$this->$carrierName = $carrier;

		$className = 'pg_tripleg_' . $triplegNumber . '_class';
		$this->$className = $class;

		$destFromName = 'pg_tripleg_' . $triplegNumber . '_destination_from';
		$this->$destFromName = $destFrom;

		$destToName = 'pg_tripleg_' . $triplegNumber . '_destination_to';
		$this->$destToName = $destTo;

		$stopOverName = 'pg_tripleg_' . $triplegNumber . '_stopover';
		$this->$stopOverName = $stopOver;

		$basisCodeName = 'pg_tripleg_' . $triplegNumber . '_fare_basis_code';
		$this->$basisCodeName = $basisCode;

		$flightNumberName = 'pg_tripleg_' . $triplegNumber . '_flight_number';
		$this->$flightNumberName = $flightNumber;
	}
}
