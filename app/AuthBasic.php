<?php
require 'libs/Sensor.php';
require './libs/DataBaseConn.php';


class AuthBasic {
	
	public function genFingerprint($algo){
        $sensor=new Sensor();
		return $sensor->genFingerprint($algo);
	}

	/**
	 * @desc Generuje kod wymagany do podania podczas autoryzacji dostępu, wg. podanych parametrów
	 * @param int $length Długość kodu - liczba znaków
	 * @param int $min Minimalna wartość dla generowanego numeru
	 * @param int $max Maksymalna wartość dla generowanego numeru
	 * @return int Zwraca wygenerowaną na podstawie parametrów liczbę, która musi zostać uzupełniana zerami, jeżeli trzeba spełnić długość
	 */
    private function createCode(	$length=6, $min=1, $max=999999 ){
		$max = substr($max,0,$length);
		return str_pad(mt_rand($min,$max),$length,'0',STR_PAD_LEFT);
	}

    public function compAuthCode( $emlAuth, $idzAuth, $authCode ){}
    public function doAuthByEmail( $person, $email ){}
    public function checkIfValidReqest( $person, $email ){}
    private function checkIfValidReqest2f( $emlAuth, $idzAuth ){}

    
    /**
     * @desc Tworzy wpis w BD z numerem pozwalającym na uwierzytelnienie Requesta
     * Tworzony Token do uwierzytelnienia zapisując adres Email oraz ID użytkownika
     * Token musi zostać wysłany na pocztę użytkownika, stąd zwracany jest Obiekt informacyjny
     * @param string $email Adres email użytkownika do uwierzytelnienia
     * @param int $id	Numer ID użytkownika do uwierzytelnienia
     * @return array|false	Wygenerowany Token LUB Fałsz
     */
    private function createAuthToken( $email, $id){
        $sensor=new Sensor();
        $authCode = $this->createCode();
        $authDate = date("Y-m-d");
        $authHours = date("H:i:s");
        $addrIp = $sensor->addrIp();
        $opSys =$sensor->system();
        $browser = $sensor->browser();
        $cont = array(
            'emlAuth'=>$email,'authCode'=>$authCode,
            'authDate'=>$authDate,'authHour'=>$authHours,
            'addrIp'=>$addrIp,'reqOs'=>$opSys,'reqBrw'=>$browser
        );
        $tbl = 'cmsWebsiteAuth';
        $cols = 'session_id, usrId, addrIp, fingerprint, dateTime, content, email, authCode';
        $vals = '1234567890,$id,$addrIp,hash_hmac(sha512+USER_AGENT+hash()+TRUE),$dt,0,$eml,$code';
        $file = dirname(__FILE__).'/db.txt';
        file_put_contents($file,serialize($cont));
        $fData = file_get_contents($file);
        $tok = (unserialize($fData)==$cont) ? 0 : 'err:1045';
        $resp = ($tok===0) ? $cont : false;
        return $resp;
    }
    public function verifyQuickRegCode($codeNo){}

}
?>