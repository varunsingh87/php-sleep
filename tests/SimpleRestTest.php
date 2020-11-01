<?php 

namespace VarunS\BorumSleep\Tests;

use PHPUnit\Framework\TestCase;
use VarunS\BorumSleep\SimpleRest;

class SimpleRestTest extends TestCase {
    private SimpleRest $simpleRestService;

    public function setUp() : void {
        $this->simpleRestService = new SimpleRest();
    }

    // TODO #3 Tests for SimpleRest
    public function setHttpHeaders_isCorrect() {
        
    }

    /**
     * @test
     */
    public function getHttpStatusMessage_isCorrect() {
        $statusMessage = $this->simpleRestService->getHttpStatusMessage(200);
        $this->assertEquals($statusMessage, "OK");
    }

    /**
     * @test
     */
    public function getHttpStatusMessage_withInvalidStatusCode_gives_500() {
        $statusMessage = $this->simpleRestService->getHttpStatusMessage(111);
        $statusMessage500 = $this->simpleRestService->getHttpStatusMessage(500);
        $this->assertEquals($statusMessage, $statusMessage500);
    }
}
?>