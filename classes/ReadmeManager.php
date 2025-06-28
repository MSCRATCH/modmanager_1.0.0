<?php

//ReadmeManager.php [Class to manage the readmes.]
//file_readme.
//pathologicalplay [MMXXV]

class ReadmeManager {

private $db;
private $file_id;
private $file_readme_content;
private $error_container;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setFileReadmeContent($file_readme_content) {
$this->file_readme_content = $file_readme_content;
}

public function setErrorContainer(ErrorContainer $error_container) {
$this->error_container = $error_container;
}

//Set methods.

//Readme output.

private function getFileReadmeDb() {
$conn = $this->db->connect();
$get_file_readme = $conn->prepare("SELECT file_readme.file_readme_content, files.file_id, files.file_name FROM file_readme INNER JOIN files ON file_readme.file_id = files.file_id WHERE file_readme.file_id = ?");
$get_file_readme->bind_param('i', $this->file_id);
$get_file_readme->execute();
$result = $get_file_readme->get_result()->fetch_assoc();
$this->db->closeConnection();
return $result ?: false;
}

public function getFileReadme() {
$result = $this->getFileReadmeDb();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Readme output.

//Check if a readme is available.

private function checkFileReadmeDb() {
$conn = $this->db->connect();
$check_file_readme = $conn->prepare("SELECT file_readme_content FROM file_readme WHERE file_id = ?");
$check_file_readme->bind_param('i', $this->file_id);
$check_file_readme->execute();
$result = $check_file_readme->get_result()->fetch_assoc();
$this->db->closeConnection();
return $result ?: false;
}

public function checkFileReadme() {
$result = $this->checkFileReadmeDb();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Check if a readme is available.

//Check if the form is not empty.

private function checkIfEmpty() {
if (empty($this->file_readme_content)) {
$this->error_container->addError('You must provide a readme.');
}
}

public function setCheckIfReadmeIsEmpty() {
$this->checkIfEmpty();
}

//Check if the form is not empty.

//Save Readme.

private function createReadmeDb() {
$conn = $this->db->connect();
$create_readme = $conn->prepare("INSERT INTO file_readme(file_readme_content, file_id) VALUES(?, ?)");
$create_readme->bind_param('si', $this->file_readme_content, $this->file_id);
$result = $create_readme->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function createReadme() {
if ($this->error_container->hasErrors()) {
return false;
} else {
if ($this->createReadmeDb()) {
return true;
} else {
throw new Exception("A critical error occurred while saving the readme.");
}
}
}

//Save Readme.

//Update Readme.

private function updateReadmeDb() {
$conn = $this->db->connect();
$update_readme = $conn->prepare("UPDATE file_readme SET file_readme_content = ? WHERE file_id = ?");
$update_readme->bind_param('si', $this->file_readme_content, $this->file_id);
$result = $update_readme->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function updateReadme() {
if ($this->error_container->hasErrors()) {
return false;
} else {
if ($this->updateReadmeDb()) {
return true;
} else {
throw new Exception("A critical error occurred while updating the readme.");
}
}
}

//Update Readme.

//Remove Readme.

private function removeReadmeDb() {
$conn = $this->db->connect();
$remove_readme = $conn->prepare("DELETE FROM file_readme WHERE file_id = ? LIMIT 1");
$remove_readme->bind_param('i', $this->file_id);
$result = $remove_readme->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeReadme() {
if ($this->removeReadmeDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the readme.");
}
}

//Remove Readme.


}
