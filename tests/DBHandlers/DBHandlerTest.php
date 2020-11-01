<?php 

namespace VarunS\BorumSleep\Tests;
use VarunS\BorumSleep\DBHandlers\DBHandler;
use PHPUnit\Framework\TestCase;

class DBHandlerTest extends TestCase {
    private DBHandler $dbHandler;

    public function setUp() : void {
        $this->dbHandler = new DBHandler();
    }

    // TODO: #2
}

class DBHandlerStaticTest extends TestCase {
    /**
     * @test
     */
    public function generateApiKey_isRandom() {
        $firstGenerApiKey = DBHandler::generateApiKey();
        $secondGenerApiKey = DBHandler::generateApiKey();
        $this->assertNotEqualsIgnoringCase($firstGenerApiKey, $secondGenerApiKey);
    }
}

?>