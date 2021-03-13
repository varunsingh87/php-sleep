<?php 

namespace VarunS\PHPSleep\Tests\DBHandlers;

use PHPUnit\Framework\TestCase;
use VarunS\PHPSleep\SimpleRest;

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

    /**
     * @test
     */
    public function handleNonNumericId_returnsArray() {
        $this->assertIsArray(SimpleRest::handleNonNumericId(5));
        $this->assertIsArray(SimpleRest::handleNonNumericId("103"));
    }

    public function handleNonNumericId_withValidId_gives_100() {
        $this->assertEquals(SimpleRest::handleNonNumericId(10)["statusCode"], 100);
        $this->assertEquals(SimpleRest::handleNonNumericId("10")["statusCode"], 100);
    }

    public function handleNonNumericId_withInvalidId_gives_400() {
        $this->assertEquals(SimpleRest::handleNonNumericId("abc")["statusCode"], 400);
        $this->assertEquals(SimpleRest::handleNonNumericId("5ab")["statusCode"], 400);
    }

    /**
     * @test
     */
    public function parseAuthorizationHeader_isCorrect() {
        $expectedParsedValue = "abcdef";
        $this->assertEquals(SimpleRest::parseAuthorizationHeader("Basic " . $expectedParsedValue), $expectedParsedValue);
    }
}
?>