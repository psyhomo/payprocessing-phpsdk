<?php

namespace Platron\PhpSdk;

use SimpleXMLElement;

class SigHelper {

	/** @var string Секретное слово */
	protected string $secretKey;


	/**
	 * @param string $secretKey
	 */
	public function __construct(string $secretKey) {
		$this->secretKey = $secretKey;
	}


	/**
	 * Get script name from URL
	 * @param string $url
	 * @return string
	 */
	public function getScriptNameFromUrl(string $url): string {
		$path = parse_url($url, PHP_URL_PATH);
		$len = strlen($path);
		if ($len == 0 || '/' == $path[ $len - 1 ]) {
			return "";
		}

		return basename($path);
	}


	/**
	 * Creates a signature
	 * @param string $scriptName String where will be request
	 * @param array $params associative array of parameters for the signature
	 * @return string
	 */
	public function make(string $scriptName, array $params): string {
		$flatParams = $this->makeFlatParamsArray($params);

		return md5($this->makeSigStr($scriptName, $flatParams));
	}


	/**
	 * Verifies the signature
	 * @param string $signature
	 * @param string $scriptName
	 * @param array $params Associative array of parameters for the signature
	 * @return bool
	 */
	public function check(string $signature, string $scriptName, array $params): bool {
		return $signature === $this->make($scriptName, $params);
	}


	/**
	 * Verifies the signature in xml
	 * @param string $signature
	 * @param string $scriptName
	 * @param SimpleXMLElement|string $xml
	 * @return bool
	 * @throws \Exception
	 */
	public function checkXml(string $signature, string $scriptName, SimpleXMLElement|string $xml): bool {
		return $signature === $this->makeXml($scriptName, $xml);
	}


	/**
	 * Make the signature for XML
	 * @param string $scriptName String where will be request
	 * @param SimpleXMLElement|string $xml
	 * @return string
	 * @throws \Exception
	 */
	public function makeXml(string $scriptName, SimpleXMLElement|string $xml): string {
		$flatParams = $this->makeFlatParamsXML($xml);

		return $this->make($scriptName, $flatParams);
	}


	/**
	 * Returns flat array of XML params
	 * @param (string|SimpleXMLElement) $xml
	 * @param string $parentName
	 * @return array
	 * @throws \Exception
	 */
	private function makeFlatParamsXML(SimpleXMLElement|string $xml, string $parentName = ''): array {

		if (!$xml instanceof SimpleXMLElement) {
			$xml = new SimpleXMLElement($xml);
		}

		$params = [];
		$i = 0;
		foreach ($xml->children() as $tag) {

			$i++;
			if ('pg_sig' === $tag->getName())
				continue;

			/**
			 * Имя делаем вида tag001subtag001
			 * Чтобы можно было потом нормально отсортировать и вложенные узлы не запутались при сортировке
			 */
			$name = $parentName . $tag->getName() . sprintf('%03d', $i);

			if ($tag->children()->count() > 0) {
				$params = array_merge($params, $this->makeFlatParamsXML($tag, $name));
				continue;
			}

			$params += [$name => (string)$tag];
		}

		return $params;
	}


	/**
	 * Return concated string to make hash
	 * @param string $scriptName
	 * @param array $params
	 * @return string
	 */
	private function makeSigStr(string $scriptName, array $params): string {
		if (!empty($params['pg_sig'])) {
			unset($params['pg_sig']);
		}

		ksort($params);

		array_unshift($params, $scriptName);
		$params[] = $this->secretKey;

		return join(';', $params);
	}


	/**
	 * Returns flat array
	 * @param array $params
	 * @param string $parentName
	 * @return array
	 */
	private function makeFlatParamsArray(array $params, string $parentName = ''): array {
		$flatParams = [];
		$i = 0;
		foreach ($params as $key => $val) {
			$i++;
			if ('pg_sig' === $key)
				continue;

			/**
			 * Имя делаем вида tag001subtag001
			 * Чтобы можно было потом нормально отсортировать и вложенные узлы не запутались при сортировке
			 */
			if (is_int($key)) {
				$name = substr($parentName, 0, strlen($parentName) - 3) . sprintf('%03d', $i);
			} else {
				$name = $parentName . $key . sprintf('%03d', $i);
			}

			if (is_array($val)) {
				$flatParams = array_merge($flatParams, $this->makeFlatParamsArray($val, $name));
				continue;
			}

			$flatParams += [$name => (string)$val];
		}

		return $flatParams;
	}
}
