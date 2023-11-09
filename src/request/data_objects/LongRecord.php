<?php

namespace Platron\PhpSdk\request\data_objects;

use Platron\PhpSdk\Exception;

class LongRecord extends BaseData {

	/** @var LongRecordTripleg[] Список шагов полета */
	public array $triplegs = [];

	/** @var string Имя пассажира */
	protected string $pg_ticket_passenger_name;

	/** @var string Номер билета */
	protected string $pg_ticket_number;

	/** @var string|bool Возможна ли остановка */
	protected string|bool $pg_ticket_restricted;

	/** @var string Билетная система */
	protected string $pg_ticket_system;

	/** @var string Код билетного агента */
	protected string $pg_ticket_agency_code;


	/**
	 * @param string $passangerName
	 * @param string $ticketNumber
	 * @param bool $ticketRestricked
	 */
	public function __construct(string $passangerName, string $ticketNumber, bool $ticketRestricked) {
		$this->pg_ticket_passenger_name = $passangerName;
		$this->pg_ticket_number = $ticketNumber;
		$this->pg_ticket_restricted = $ticketRestricked;
	}


	/**
	 * Установить билетную систему
	 * @param string $ticketSystem
	 * @return $this
	 */
	public function setTicketSystem(string $ticketSystem): self {
		$this->pg_ticket_system = $ticketSystem;

		return $this;
	}


	/**
	 * Установить код агента
	 * @param string $ticketAgencyCode
	 * @return $this
	 */
	public function setAgencyCode(string $ticketAgencyCode): self {
		$this->pg_ticket_agency_code = $ticketAgencyCode;

		return $this;
	}


	/**
	 * Добавить шаг в билет. Возможно добавить только 4 шага
	 * @param LongRecordTripleg $tripLeg
	 * @return $this
	 * @throws Exception
	 */
	public function addTripLeg(LongRecordTripleg $tripLeg): self {

		if (count($this->triplegs) > 3) {
			throw new Exception('Доступно создание только 4 шагов');
		}

		$this->triplegs[] = $tripLeg;

		return $this;
	}


	public function getParameters(): array {

		$parameters = [];
		foreach (get_object_vars($this) as $name => $value) {
			if ($value && $name != 'triplegs') {
				$parameters[ $name ] = $value;
			}
		}

		foreach ($this->triplegs as $tripLeg) {
			foreach ($tripLeg->getParameters() as $name => $value) {
				if ($value) {
					$parameters[ $name ] = $value;
				}
			}
		}

		return $parameters;
	}
}
