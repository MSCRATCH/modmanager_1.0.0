<?php

//Dbh.php [Class to access the database.]
//pathologicalplay [MMXXV]

class Dbh {

private $db;

private $servername = "";
private $username = "";
private $password = "";
private $db_name = "";

public function connect() {
$this->db = new mysqli ($this->servername, $this->username, $this->password, $this->db_name);
$this->db->set_charset ('utf8');
if ($this->db->connect_errno) {
die ("Connection has failed.");
}
return $this->db;
}

public function closeConnection() {
return $this->db->close();
}

}
