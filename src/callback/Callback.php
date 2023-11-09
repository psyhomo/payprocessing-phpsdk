<?php

namespace Platron\PhpSdk\callback;

use Exception;
use Platron\PhpSdk\SigHelper;
use SimpleXMLElement;

class Callback {

	/** @var string Скрипт магазина, на который делается запрос */
	protected string $urlScriptName;

	/** @var SigHelper Помощник для создания подписи */
	protected SigHelper $sigHelper;


	/**
	 * @param string $urlScriptName Название скрипта (часть после последнего /), из url, на который Platron делает
	 *   запрос. Например, www.site.ru/request/handle - будет handle
	 * @param string $secretKey
	 */
	public function __construct(string $urlScriptName, string $secretKey) {
		$this->urlScriptName = $urlScriptName;
		$this->sigHelper = new SigHelper($secretKey);
	}


	/**
	 * Валидировать запрос от platron (внимательно проверяем, что ваша система не добавляет дополнительно параметров,
	 * которых не было в запросе от platron)
	 * @param array $params
	 * @return boolean
	 */
	public function validateSig(array $params): bool {
		return isset($params['pg_sig']) && is_scalar($params['pg_sig']) &&
			$this->sigHelper->check($params['pg_sig'], $this->urlScriptName, $params);
	}


	/**
	 * Можно ли отказаться от платежа
	 * @param array $params
	 * @return boolean
	 */
	public function canReject(array $params): bool {
		return !empty($params['pg_can_reject']);
	}


	/**
	 * Ответить ошибкой
	 * @param array $params
	 * @param string $error
	 * @return SimpleXMLElement
	 * @throws Exception
	 */
	public function responseError(array $params, string $error): SimpleXMLElement {
		return $this->response(@$params['pg_salt'], 'error', $error);
	}


	/**
	 * В ответе попросить вернуть платеж
	 * @param array $params
	 * @param string $description
	 * @return SimpleXMLElement
	 * @throws Exception
	 */
	public function responseRejected(array $params, string $description): SimpleXMLElement {
		return $this->response(@$params['pg_salt'], 'rejected', $description);
	}


	/**
	 * Ответить, что успешно получил запрос
	 * @param array $params
	 * @return SimpleXMLElement
	 * @throws Exception
	 */
	public function responseOk(array $params): SimpleXMLElement {
		return $this->response(@$params['pg_salt'], 'ok', 'ok');
	}


	/**
	 * Ответить в Platron
	 * @throws Exception
	 */
	private function response($salt, $status, $description): SimpleXMLElement {

		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><response/>');
		$xml->addChild('pg_salt', $salt); // в ответе необходимо указывать тот же pg_salt, что и в запросе
		$xml->addChild('pg_status', $status);
		$xml->addChild('pg_description', $description);
		$xml->addChild('pg_sig', $this->sigHelper->makeXml($this->urlScriptName, $xml));

		return $xml;
	}
}
