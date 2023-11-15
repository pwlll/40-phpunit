<?php
require('../app/AuthBasic.php');

use PHPUnit\Framework\TestCase;
class AuthBasicTest extends TestCase {

    public function setUp() : void{
        $this->instance = new AuthBasic();
    }
    public function tearDown() : void{
        unset($this->instance);
    }


    public function testCreateCode(){
        $output = $this->instance->createCode();

        $this->assertIsNumeric($output);
        $this->assertEquals(6,strlen($output));
    
        $output = $this->instance->createCode(4);
        $this->assertIsNumeric($output);
        $this->assertEquals(4,strlen($output));
    }

    public function testCreateAuthToken(){
        $testArr = array(
            'emlAuth'=>'test@local.test','authCode'=>'123',
            'authDate'=>date("Y-m-d"),'authHour'=>date("H:i:s"),
            'addrIp'=>'192.168.0.1','reqOs'=>'Linux','reqBrw'=>'FF'
        );

        $output = $this->instance->createAuthToken('test@local.test',1);
        
        $output['authCode'] = '123';
        $this->assertEquals($testArr,$output);
        $this->assertInstanceOf($testArr, $output);
        $this->assertTrue(strlen($output['authCode'])==6);
        $this->assertInstanceOf(String::class, $output["authCode"]);
    }

    public function testGenFingerprint(){
        $this->assertEquals($exp,$output,'Tablice są różne');
    }

}




?>