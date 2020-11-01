<?php 

namespace VarunS\BorumSleep\Tests;

use PHPUnit\Framework\TestCase;
use VarunS\BorumSleep\Helpers;

class HelpersTest extends TestCase {
    /**
     * @test
     */
    public function parseAuthorizationHeader_isCorrect() {
        $expectedParsedValue = "abcdef";
        $this->assertEquals(Helpers::parseAuthorizationHeader("Basic " . $expectedParsedValue), $expectedParsedValue);
    }
}

?>