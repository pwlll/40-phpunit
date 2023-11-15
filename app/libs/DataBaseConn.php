<?php
class DataBaseConn {
    private String $host;
    private String $user;
    private String $password;
    private String $database;


    public function put(String $table, $columns, $values) {
        $mysqli = new mysqli($host, $user, $password, $database);
        if ($mysqli -> connect_errno) {
            return false;
        }
        $query="INSERT INTO ".$table." (".$columns.") VALUES (".$values.");";

        if($mysqli->query($query) === FALSE) {
            $mysqli->close();
            return false;
        }
        $mysqli->close();
        return true;
    }
    public function get(String $table, $columns, $options) {
        $mysqli = new mysqli($host, $user, $password, $database);
        if ($mysqli -> connect_errno) {
            return false;
        }

        $query = "SELECT ".$columns." FROM ".$table." WHERE ".$arrayOptions.";";

        $result = $mysqli->query($query);
        if($result->num_rows<1) {
            $mysqli->close();
            return false;
        }
        while($row = $result->fetch_assoc()) {
            echo $row;
        }
        $mysqli->close();
        return true;
    }
    public function delete(String $table, $options) {
        $mysqli=new mysqli($host,$user,$password,$database);
        if ($mysqli -> connect_errno) {
            return false;
        }
        $query="DELETE FROM ".$table." WHERE ".$options.";";

        $result = $mysqli->query($query);
        if(!$result){
            $mysqli->close();
            return false;
        }
        $mysqli->close();
        return true;
    }
}

?>