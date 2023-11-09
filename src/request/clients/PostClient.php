<?php

namespace Platron\PhpSdk\request\clients;

use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\request_builders\RequestBuilder;
use Platron\PhpSdk\SigHelper;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use SimpleXMLElement;

class PostClient implements iClient {

	/** @var string|null Описание ошибки */
	protected ?string $errorDescription;

	/** @var mixed|null Код ошибки */
	protected mixed $errorCode;

	/** @var int Номер магазина */
	protected int $merchant;

	/** @var SigHelper Помощник создания подписи */
	protected SigHelper $sigHelper;

	/** @var string */
	protected string $secretKey;

	/** @var LoggerInterface|null */
	protected ?LoggerInterface $logger;

	/** @var array */
	protected array $additionalCurlParameters = [];


	/**
	 * @inheritdoc
	 */
	public function __construct(int $merchant, string $secretKey, LoggerInterface $logger = null) {
		$this->merchant = $merchant;
		$this->sigHelper = new SigHelper($secretKey);
		$this->secretKey = $secretKey;
		$this->logger = $logger;
	}


	/**
	 * Отправить запрос
	 * @inheritdoc
	 * @return SimpleXMLElement
	 * @throws Exception
	 * @throws \Exception
	 */
	public function request(RequestBuilder $requestBuilder): SimpleXMLElement {

		$parameters = $requestBuilder->getParameters();
		$url = $requestBuilder->getRequestUrl();

		$parameters['pg_merchant_id'] = $this->merchant;
		$parameters['pg_salt'] = rand(21, 43433);

		$fileName = pathinfo($url);
		$parameters['pg_sig'] = $this->sigHelper->make($fileName['basename'], $parameters);

		$curl = curl_init();
		curl_setopt_array($curl, $this->additionalCurlParameters);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);

		if ($this->logger) {
			$this->logger->log(LogLevel::INFO, 'Request url ' . $requestBuilder->getRequestUrl() . ' with params ' . print_r($parameters, true));
			$this->logger->log(LogLevel::INFO, 'Response ' . $response);
		}

		if (curl_errno($curl)) {
			throw new Exception(curl_error($curl), curl_errno($curl));
		}

		curl_close($curl);

		if ($this->hasError($response, $url)) {
			throw new Exception($this->errorDescription, $this->errorCode ?? 0);
		}

		return new SimpleXMLElement($response);
	}


	/**
	 * Добавляет дополнительные параметры к curl клиенту.
	 * @param array $parameters
	 */
	public function setAdditionalCurlParameters(array $parameters): void {
		$this->additionalCurlParameters = $parameters;
	}


	/**
	 * Проверить ответ на наличие ошибок
	 * @param string $response
	 * @param string $url
	 * @return boolean
	 * @throws \Exception
	 */
	private function hasError(string $response, string $url): bool {

		try {
			$xml = new SimpleXMLElement($response);
		} catch (\Exception $e) {
			$this->errorCode = $e->getCode();
			$this->errorDescription = $e->getMessage();

			return true;
		}

		$sigHelper = new SigHelper($this->secretKey);

		if (empty($xml->pg_sig) || !$sigHelper->checkXml($xml->pg_sig, $sigHelper->getScriptNameFromUrl($url), $xml)) {
			$this->errorDescription = 'Not valid sig in response';

			return true;
		}

		if (!empty($xml->pg_error_code)) {
			$this->errorCode = (string)$xml->pg_error_code;
			$this->errorDescription = (string)$xml->pg_error_description;

			return true;
		}

		return false;
	}

}
