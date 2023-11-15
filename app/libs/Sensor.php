<?php
class Sensor{
    public function isLocal(){
        return getHostByName(getHostName());
    }
    public function addrIp($getProxy = null) {
        $address=$_SERVER["REMOTE_ADDR"];
        $forwarder=$_SERVER["HTTP_X_FORWARDER_FOR"];

        return $address;
    }
    public function browser() {
        $headers=new WhichBrowser\Parser(getallheaders());
        return $headers->browser->toString();
    }
    public function system() {
        $headers=new WhichBrowser\Parser(getallheaders());
        return $headers->os->toString();
    }
    public function genFingerprint($algo="sha512") {
        $userAgent=$_SERVER['HTTP_USER_AGENT'];
        $hash=hash_hmac($algo,$userAgent,hash($algo, $UserAgent),true);
        return $hash;
    } 
}


?>