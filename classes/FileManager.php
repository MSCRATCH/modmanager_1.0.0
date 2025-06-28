<?php

//FileManager.php [Class to manage the files table.]
//files.
//pathologicalplay [MMXXV]

class FileManager {

private $db;
private $category_id;
private $entries_per_page;
private $offset;
private $file_id;
private $file_name;
private $file_author;
private $file_download;
private $file_title_image;
private $file_description;
private $file_type;
private $error_container;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setCategoryId($category_id) {
$this->category_id = $category_id;
}

public function setEntriesPerPage($entries_per_page) {
$this->entries_per_page = $entries_per_page;
}

public function setOffset($offset) {
$this->offset = $offset;
}

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setFileName($file_name) {
$this->file_name = $file_name;
}

public function setFileAuthor($file_author) {
$this->file_author = $file_author;
}

public function setFileDownload($file_download) {
$this->file_download = $file_download;
}

public function setFileTitleImage($file_title_image) {
$this->file_title_image = $file_title_image;
}

public function setFileDescription($file_description) {
$this->file_description = $file_description;
}

public function setFileType($file_type) {
$this->file_type = $file_type;
}

public function setErrorContainer(ErrorContainer $error_container) {
$this->error_container = $error_container;
}

//Set methods.

//Check if a file exists. [controller->item.php]

private function validateIdOfFileDb() {
$conn = $this->db->connect();
$stmt = $conn->prepare("SELECT COUNT(*) AS file_count FROM files WHERE file_id = ?");
$stmt->bind_param('i', $this->file_id);
$stmt->execute();
$stmt->bind_result($file_count);
$stmt->fetch();
$this->db->closeConnection();
return (INT) $file_count;
}

public function validateIdOfFile() {
$file_count = $this->validateIdOfFileDb();
if ($file_count > 0) {
return true;
} else {
return false;
}
}

//Check if a file exists. [controller->item.php]

//Total number of records (files) for pagination. [controller->items.php]

private function getNumberOfFilesDb() {
$conn = $this->db->connect();
$number_of_records = $conn->prepare("SELECT file_id, file_name, file_title_image, file_author, file_uploaded, file_description FROM files WHERE category_id = ?");
$number_of_records->bind_param('i', $this->category_id);
$number_of_records->execute();
$number_of_records->store_result();
$total_number_of_records = $number_of_records->num_rows;
$this->db->closeConnection();
if ($total_number_of_records > 0) {
return (INT) $total_number_of_records;
} else {
return false;
}
}

public function getNumberOfFiles() {
$total_number_of_records = $this->getNumberOfFilesDb();
if ($total_number_of_records !== false) {
return $total_number_of_records;
} else {
return false;
}
}

//Total number of records (files) for pagination. [controller->items.php]

//Output of the file preview (files) with pagination. [controller->items.php]

private function getFileDescriptionPreviewDb() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$conn = $this->db->connect();
$get_files = $conn->prepare("SELECT file_id, file_name, file_title_image, file_author, file_uploaded, file_description FROM files WHERE category_id = ? ORDER BY file_uploaded DESC LIMIT $offset, $entries_per_page");
$get_files->bind_param('i', $this->category_id);
$get_files->execute();
$result = $get_files->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getFileDescriptionPreview() {
$result = $this->getFileDescriptionPreviewDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of the file preview (files) with pagination. [controller->items.php]

//Output the full file view (files). [controller->item.php, controller->edit_file.php]

private function getFileDescriptionDb() {
$conn = $this->db->connect();
$get_file_description = $conn->prepare("SELECT file_id, file_name, file_type, file_title_image, file_author, file_uploaded, file_download, file_description FROM files WHERE file_id = ?");
$get_file_description->bind_param('i', $this->file_id);
$get_file_description->execute();
$result = $get_file_description->get_result()->fetch_assoc();
$this->db->closeConnection();
return $result ?: false;
}

public function getFileDescription() {
$result = $this->getFileDescriptionDb();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output the full file view (files). [controller->item.php, controller->edit_file.php]

//Output of the file preview (files) with the download path. [controller->download.php]

private function getDownloadDescriptionDb() {
$conn = $this->db->connect();
$get_download_description = $conn->prepare("SELECT file_name, file_download FROM files WHERE file_id = ?");
$get_download_description->bind_param('i', $this->file_id);
$get_download_description->execute();
$result = $get_download_description->get_result()->fetch_assoc();
$this->db->closeConnection();
return $result ?: false;
}

public function getDownloadDescription() {
$result = $this->getDownloadDescriptionDb();
if ($result !== false) {
return $result;
} else {
return false;
}
}

//Output of the file preview (files) with the download path. [controller->download.php]

//Total number of files (files) for pagination. [controller->file_management.php]

private function getNumberOfAllFilesDb() {
$conn = $this->db->connect();
$get_number_of_all_files = $conn->query("SELECT file_id, file_name, file_type, file_title_image, file_author, file_uploaded, file_description, file_download, category_id FROM files");
$total_number_of_files = $get_number_of_all_files->num_rows;
$this->db->closeConnection();
if ($total_number_of_files > 0) {
return (INT) $total_number_of_files;
} else {
return false;
}
}

public function getNumberOfAllFiles() {
$total_number_of_files = $this->getNumberOfAllFilesDb();
if ($total_number_of_files !== false) {
return $total_number_of_files;
} else {
return false;
}
}

//Total number of files (files) for pagination. [controller->file_management.php]

//Output of all files for the backend. [controller->file_management.php]

private function getAllFilesDb() {
$offset = $this->offset;
$entries_per_page = $this->entries_per_page;
$conn = $this->db->connect();
$stmt = $conn->query("SELECT file_id, file_name, file_type, file_title_image, file_author, file_uploaded, file_description, file_download, category_id FROM files ORDER BY file_uploaded DESC LIMIT $offset, $entries_per_page");
$result = $stmt->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getAllFiles() {
$result = $this->getAllFilesDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of all files for the backend. [controller->file_management.php]

//Save the file description. [controller->create_file.php]

private function validateDescriptionCreateFile() {
if (empty($this->file_name) OR empty($this->file_author) OR empty($this->file_description)) {
$this->error_container->addError('The file description is required.');
}
}

public function setValidateDescriptionCreateFile() {
$this->validateDescriptionCreateFile();
}

private function createFileDb() {
$conn = $this->db->connect();
$create_file = $conn->prepare("INSERT INTO files(file_name, file_type, file_author, file_uploaded, file_description, category_id) VALUES(?, ?, ?, NOW(), ?, ?)");
$create_file->bind_param('ssssi', $this->file_name, $this->file_type, $this->file_author, $this->file_description, $this->category_id);
$result = $create_file->execute();
$new_file_id = $conn->insert_id;
$this->db->closeConnection();
if ($result) {
return $new_file_id;
} else {
return false;
}
}

public function createFile() {
if ($this->error_container->hasErrors()) {
return false;
} else {
$result = $this->createFileDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while creating a file.");
}
}
}

//Save the file description. [controller->create_file.php]

//Updating the file description. [controller->edit_file.php]

private function validateDescription() {
if (empty($this->file_name) OR empty($this->file_author) OR empty($this->file_description)) {
$this->error_container->addError('The file description is required.');
}
}

private function updateFileDb() {
$conn = $this->db->connect();
$update_file = $conn->prepare("UPDATE files SET file_name = ?, file_type = ?, file_author = ?, file_download = ?, file_title_image = ?, file_description = ?, category_id = ? WHERE file_id = ?");
$update_file->bind_param('ssssssii', $this->file_name, $this->file_type, $this->file_author, $this->file_download, $this->file_title_image, $this->file_description, $this->category_id, $this->file_id);
$result = $update_file->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function updateFile() {
$this->validateDescription();
if ($this->error_container->hasErrors()) {
return false;
} else {
$result = $this->updateFileDb();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while updating file.");
}
}
}

//Updating the file description. [controller->edit_file.php]

//Remove file. [controller->file_management.php]

private function removeFileDb() {
$conn = $this->db->connect();
$remove_file = $conn->prepare("DELETE FROM files WHERE file_id = ? LIMIT 1");
$remove_file->bind_param('i', $this->file_id);
$result = $remove_file->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeFile() {
if ($this->removeFileDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing the file.");
}
}

//Remove file. [controller->file_management.php]

}
