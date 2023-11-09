<?php

namespace Platron\PhpSdk\tests\unit;

use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\Exception;
use Platron\PhpSdk\request\clients\PostClient;
use Platron\PhpSdk\request\request_builders\RequestBuilder;

class ClientTest extends TestCase {

	/** @var PostClient */
	protected PostClient $fixture;


	public function setUp(): void {
		$this->fixture = new PostClient('82', 'sdfvdfvfsdvfsd');
	}


	/**
	 * @dataProvider provider
	 * @param string $url
	 * @param array $parameters
	 * @return boolean
	 */
	public function testRequest(string $url, array $parameters) {
		try {
			$requestBuilder = $this->generateMock($url, $parameters);
			$this->fixture->request($requestBuilder);
		} catch (Exception) {
			return true;
		} catch (\Exception) {
		}

		return false;
	}


	public function provider(): array {
		return [
			['www.not-found-site.sdcasdasdcasdc', [1, 2, 3]],
			['www.platron.ru/init_payment.php', [1, 2, 3]],
			['www.google.com', []],
		];
	}


	/**
	 * @param string $url
	 * @param array $params
	 * @return RequestBuilder
	 */
	private function generateMock(string $url, array $params): RequestBuilder {
		$stubRequestBuilder = $this->getMockBuilder('Platron\PhpSdk\request\request_builders\RequestBuilder')
			->disableOriginalConstructor()->setMethods(['getParameters', 'getRequestUrl'])->getMock();
		$stubRequestBuilder->expects($this->any())->method('getParameters')->willReturn($params);
		$stubRequestBuilder->expects($this->any())->method('getRequestUrl')->willReturn($url);

		return $stubRequestBuilder;
	}
}
