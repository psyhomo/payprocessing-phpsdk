<?php

namespace Platron\PhpSdk\tests\unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Platron\PhpSdk\callback\Callback;

class CallbackTest extends TestCase {

	/** @var Callback */
	protected Callback $fixture;


	/**
	 * @throws Exception
	 */
	public function testOkAnswear() {
		$response = $this->fixture->responseOk(['pg_salt' => 1111]);
		$this->assertEquals('ok', $response->pg_status);
		$this->assertNotNull($response->pg_sig);
		$this->assertNotNull($response->pg_description);
		$this->assertNotNull($response->pg_salt);
	}


	/**
	 * @throws Exception
	 */
	public function testErrorAnswear() {
		$response = $this->fixture->responseError(['pg_salt' => 1111], 'some_error');
		$this->assertEquals('error', $response->pg_status);
		$this->assertNotNull($response->pg_sig);
		$this->assertNotNull($response->pg_description);
		$this->assertNotNull($response->pg_salt);
	}


	/**
	 * @throws Exception
	 */
	public function testRejectedAnswear() {
		$response = $this->fixture->responseRejected(['pg_salt' => 1111], 'reject please');
		$this->assertEquals('rejected', $response->pg_status);
		$this->assertNotNull($response->pg_sig);
		$this->assertNotNull($response->pg_description);
		$this->assertNotNull($response->pg_salt);
	}


	public function testCanReject() {
		$this->assertTrue($this->fixture->canReject(['pg_can_reject' => 1]));
		$this->assertFalse($this->fixture->canReject(['pg_can_reject' => 0]));
		$this->assertFalse($this->fixture->canReject([]));
	}


	protected function setUp(): void {
		$this->fixture = new Callback('test.php', 'adfsvsdfvsd');
	}
}
