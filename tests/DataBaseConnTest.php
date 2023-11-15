<?php
require('../app/libs/DataBaseConn.php');

use PHPUnit\Framework\TestCase;

class DataBaseConnTest extends TestCase {

    public function setUp() : void{
        $this->instance = new DataBaseConn();
    }
    public function tearDown() : void{
        unset($this->instance);
    }

    public function testDb() {
        $this->assertEquals(true, $this->instance->put("AuthBasic",'session_id','12345'));
        $this->assertEquals(true, $this->instance->get('AuthBasic','session_id','session_id=12345'));
        $this->assertEquals(true, $this->instance->delete('AuthBasic','session_id=12345'));
    }
    
}




?>