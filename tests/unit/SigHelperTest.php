<?php

namespace Platron\PhpSdk\tests\unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\SigHelper;
use SimpleXMLElement;

class SigHelperTest extends TestCase {

	/** @var SigHelper */
	protected SigHelper $fixture;


	public function setUp(): void {
		$this->fixture = new SigHelper('rofoneqaxujagexi');
	}


	public function testGetScriptNameFromUrl() {
		$this->assertEquals('test.php', $this->fixture->getScriptNameFromUrl('www.test.ru/admin/test.php'));
	}


	public function testMake() {
		$this->assertEquals('27a5edfcb35e2fa44c9adef6994af3f0', $this->fixture->make('payment.php', ['test' => 'test1', 'test2' => 'test3']));
	}


	/**
	 * @dataProvider providerCheck
	 */
	public function testCheck($sig, $scriptName, $params) {
		$this->assertTrue($this->fixture->check($sig, $scriptName, $params));
	}


	/**
	 * @dataProvider providerMakeXml
	 * @throws Exception
	 */
	public function makeXML($sig, $description, $scriptName): void {
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><response/>');
		$xml->addChild('pg_description', $description);

		$this->assertEquals($this->fixture->makeXml($scriptName, $xml), $sig);
	}


	public function providerCheck(): array {
		return [
			['27a5edfcb35e2fa44c9adef6994af3f0', 'payment.php', ['test' => 'test1', 'test2' => 'test3']],
			['329102fce0b6b85fbd319abd69550447', 'payment.php', ['foo' => [1, 2]]],
		];
	}


	public function providerMakeXml(): array {
		return [
			['7e3123d36e6aa859f40dbe4d7eff7c34', 'test', 'test.php'],
			['5ea94ad2bf3c1780f5e1912f9e4b803c', 'advsfdvsdvsd', 'request'],
		];
	}
}
