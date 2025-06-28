<?php

//ErrorHandler.php [Class to handle error messages.]
//errors.
//pathologicalplay [MMXXV]

class ErrorHandler {
private $db;
private $entries_per_page;
private $offset;

function __construct(Dbh $db) {
error_reporting(E_ALL);
ini_Set("display_errors", 0);
$this->db = $db;
}

//Set methods.

public function setEntriesPerPage($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function setOffset($offset) {
$this->offset = $offset;
}

//Set methods.

//Saving errors.

private function saveErrorsDb($errno, $errstr, $errfile, $errline) {
$conn = $this->db->connect();
$save_errors = $conn->prepare("INSERT INTO errors(errno, errstr, errfile, errline, error_created_at) VALUES(?, ?, ?, ?, NOW())");
$save_errors->bind_param('issi', $errno, $errstr, $errfile, $errline);
$result = $save_errors->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function saveErrors($errno, $errstr, $errfile, $errline) {
$this->saveErrorsDb($errno, $errstr, $errfile, $errline);
}

//Saving errors.

//Registering errors.

public function registerErrors() {
set_error_handler([$this, 'saveErrors']);
}

//Registering errors.

//Total number of errors (errors) for pagination. [controller->error_log.php]

private function getNumberOfErrorsDb() {
$conn = $this->db->connect();
$get_number_of_errors = $conn->query("SELECT errno, errstr, errfile, errline, error_created_at FROM errors");
$total_number_of_errors = $get_number_of_errors->num_rows;
$this->db->closeConnection();
if ($total_number_of_errors > 0) {
return (INT) $total_number_of_errors;
} else {
return false;
}
}

public function getNumberOfErrors() {
$total_number_of_errors = $this->getNumberOfErrorsDb();
if ($total_number_of_errors !== false) {
return $total_number_of_errors;
} else {
return false;
}
}

//Total number of errors (errors) for pagination. [controller->error_log.php]

//Output of errors. [controller->error_log.php]

private function getErrorsDb() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$conn = $this->db->connect();
$stmt = $conn->query("SELECT errno, errstr, errfile, errline, error_created_at FROM errors ORDER BY error_created_at DESC LIMIT $offset, $entries_per_page");
$result = $stmt->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getErrors() {
$result = $this->getErrorsDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}


//Output of errors. [controller->error_log.php]

}
