<?php

//FileUpdater.php [Class to update uploads.]
//pathologicalplay [MMXXV]

class FileUpdater {

private $db;
private $file;
private $image;
private $screenshots = array();
private $file_id;
private $category_id;
private $allowed_file_extensions = array("zip", "rar");
private $allowed_file_mime_types = array('application/zip', 'application/x-zip', 'application/x-zip-compressed', 'application/x-compressed', 'application/x-rar', 'application/x-rar-compressed', 'application/vnd.rar');
private $maximum_file_size = 250 * 1024 * 1024;
private $allowed_image_extensions = array("jpg", "jpeg", "png");
private $allowed_image_mime_types = array('image/jpeg', 'image/png');
private $maximum_image_size = 2 * 1024 * 1024;
private $error_container;

function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setFile($file) {
$this->file = $file['file'];
}

public function setImage($image) {
$this->image = $image['image'];
}

public function setScreenshots($screenshots) {
$this->screenshots = $screenshots['screenshots'];
}

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setCategoryId($category_id) {
$this->category_id = $category_id;
}

public function setErrorContainer(ErrorContainer $error_container) {
$this->error_container = $error_container;
}

//Set methods.

//Create new file name.

private function createNewFileName() {
$file_name = $this->file['name'];
$new_file_name = uniqid();
$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
return $final_new_file_name = $new_file_name.  "." . $file_extension;
}

//Create new file name.

//Create new file name for an image (image, screenshot).

private function createNewImageName() {
$image_name = $this->image['name'];
$new_image_name = uniqid();
$image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
return $final_new_image_name = $new_image_name.  "." . $image_extension;
}

//Create new file name for an image (image, screenshot).

//Validate the uploaded files.

private function validateFile() {
if (isset($this->file) && is_array($this->file)) {
if ($this->file['error'] === UPLOAD_ERR_OK) {

$file_size = $this->file['size'];
if ($file_size > $this->maximum_file_size) {
$this->error_container->addError('Error uploading file, invalid file Size.');
}
$file_name = $this->file['name'];
$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
if (! in_array(strtolower($file_extension), $this->allowed_file_extensions)) {
$this->error_container->addError('Error uploading file, invalid file extension. Only RAR or ZIP allowed.');
}
$file_type = $this->file['type'];
if (! in_array($file_type, $this->allowed_file_mime_types)) {
$this->error_container->addError('Error uploading file, invalid MIME Type.');
}
} elseif ($this->file['error'] === UPLOAD_ERR_NO_FILE) {
$this->error_container->addError('Error uploading file, you need to enter a file.');
}
}
}

private function validateImage() {
if (isset($this->image) && is_array($this->image)) {
if ($this->image['error'] === UPLOAD_ERR_OK) {
$image_size = $this->image['size'];
if ($image_size > $this->maximum_image_size) {
$this->error_container->addError('Error uploading image, invalid image size.');
}
$image_name = $this->image['name'];
$image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
if (! in_array(strtolower($image_extension), $this->allowed_image_extensions)) {
$this->error_container->addError('Error uploading image, invalid image extension. Only JPG, JPEG or PNG allowed.');
}
$image_type = $this->image['type'];
if (! in_array($image_type, $this->allowed_image_mime_types)) {
$this->error_container->addError('Error uploading image, invalid MIME Type.');
}
$file_image_size = getimagesize($this->image['tmp_name']);
if ($file_image_size !== false) {
$width = $file_image_size[0];
$height = $file_image_size[1];

if ($width > 800 and $height > 600 or $width < 800 and $height < 600) {
$this->error_container->addError('The cover image must be 800X600PX.');
}
} else {
$this->error_container->addError('The cover image must be 800X600PX.');
}
} elseif ($this->image['error'] === UPLOAD_ERR_NO_FILE) {
$this->error_container->addError('Error uploading image, you need to enter a image.');
}
}
}

private function validateScreenshots() {
foreach ($this->screenshots['name'] as $key => $name) {
$this->screenshot = array(
'name' => $name,
'type' => $this->screenshots['type'][$key],
'tmp_name' => $this->screenshots['tmp_name'][$key],
'error' => $this->screenshots['error'][$key],
'size' => $this->screenshots['size'][$key],
);
$this->validateScreenshot();
}
}

private function validateScreenshot() {
if (isset($this->screenshot) && is_array($this->screenshot)) {
if ($this->screenshot['error'] === UPLOAD_ERR_OK) {
$screenshot_size = $this->screenshot['size'];
if ($screenshot_size > $this->maximum_image_size) {
$this->error_container->addError('Error uploading screenshot, invalid screenshot size.');
}
$screenshot_name = $this->screenshot['name'];
$screenshot_extension = pathinfo($screenshot_name, PATHINFO_EXTENSION);
if (! in_array(strtolower($screenshot_extension), $this->allowed_image_extensions)) {
$this->error_container->addError('Error uploading file, invalid file Size.');
}
$screenshot_type = $this->screenshot['type'];
if (! in_array($screenshot_type, $this->allowed_image_mime_types)) {
$this->error_container->addError('Error uploading screenshot, invalid MIME Type.');
}
$file_image_size = getimagesize($this->screenshot['tmp_name']);
if ($file_image_size !== false) {
$width = $file_image_size[0];
$height = $file_image_size[1];

if ($width > 800 and $height > 600 or $width < 800 and $height < 600) {
$this->error_container->addError('Screenshots must be 800X600PX.');
}
} else {
$this->error_container->addError('Screenshots must be 800X600PX.');
}
} elseif ($this->screenshot['error'] === UPLOAD_ERR_NO_FILE) {
$this->error_container->addError('Error uploading screenshot, you need to enter a image.');
}
}
}

//Validate the uploaded files.

//Check if file_title_image, file_download, file_image exist.

private function checkIfFileExistsDb() {
$conn = $this->db->connect();
$check_if_file_exists = $conn->prepare("SELECT file_download FROM files WHERE file_id = ?");
$check_if_file_exists->bind_param('i', $this->file_id);
$check_if_file_exists->execute();
$check_if_file_exists->store_result();
$check_if_file_exists->bind_result($file_download);
$check_if_file_exists->fetch();
$check_if_file_exists->free_result();
$check_if_file_exists->close();
$this->db->closeConnection();
return $file_download ?: false;
}

private function checkIfImageExistsDb() {
$conn = $this->db->connect();
$check_if_image_exists = $conn->prepare("SELECT file_title_image FROM files WHERE file_id = ?");
$check_if_image_exists->bind_param('i', $this->file_id);
$check_if_image_exists->execute();
$check_if_image_exists->store_result();
$check_if_image_exists->bind_result($file_title_image);
$check_if_image_exists->fetch();
$check_if_image_exists->free_result();
$check_if_image_exists->close();
$this->db->closeConnection();
return $file_title_image ?: false;
}

private function checkIfScreenhotsExistsDb() {
$conn = $this->db->connect();
$check_if_screenhots_exists = $conn->prepare("SELECT file_image FROM file_images WHERE file_id = ?");
$check_if_screenhots_exists->bind_param('i', $this->file_id);
$check_if_screenhots_exists->execute();
$check_if_screenhots_exists->store_result();
$check_if_screenhots_exists->bind_result($file_image);
$screenhots = array();
while ($check_if_screenhots_exists->fetch()) {
$screenhots[] = array('file_image' => $file_image);
}
$check_if_screenhots_exists->free_result();
$check_if_screenhots_exists->close();
$this->db->closeConnection();
return $screenhots ?: false;
}

private function getAllFilesOfCategoryDb() {
$conn = $this->db->connect();
$get_all_files_of_category = $conn->prepare("SELECT files.file_title_image, files.file_download, file_images.file_image  FROM files LEFT JOIN file_images ON files.file_id = file_images.file_id WHERE files.category_id = ?");
$get_all_files_of_category->bind_param('i', $this->category_id);
$get_all_files_of_category->execute();
$get_all_files_of_category->store_result();
$get_all_files_of_category->bind_result($file_title_image, $file_download, $file_image);
$files_of_category = array();
while ($get_all_files_of_category->fetch()) {
$files_of_category[] = array('file_title_image' => $file_title_image, 'file_download' => $file_download, 'file_image' => $file_image);
}
$get_all_files_of_category->free_result();
$get_all_files_of_category->close();
$this->db->closeConnection();
return $files_of_category ?: false;
}

//Check if file_title_image, file_download, file_image exist.

//Remove uploaded file, image and screenshots.

public function removeExistingData() {
$existing_file = $this->checkIfFileExistsDb();
$existing_image = $this->checkIfImageExistsDb();
$existing_screenshots = $this->checkIfScreenhotsExistsDb();
if ($existing_file) {
if (file_exists('files/' . $existing_file)) {
unlink('files/' . $existing_file);
}
}
if ($existing_image) {
if (file_exists('images/' . $existing_image)) {
unlink('images/' . $existing_image);
}
}
if ($existing_screenshots) {
foreach ($existing_screenshots as $existing_screenshot) {
if (file_exists('images/' . $existing_screenshot['file_image'])) {
unlink('images/' . $existing_screenshot['file_image']);
}
}
}
}

public function removeAllFilesFromCategory() {
$existing_files_in_category = $this->getAllFilesOfCategoryDb();
if ($existing_files_in_category) {
foreach ($existing_files_in_category as $existing_file_in_category) {
if (file_exists('files/' . $existing_file_in_category['file_download'])) {
unlink('files/' . $existing_file_in_category['file_download']);
}
if (file_exists('images/' . $existing_file_in_category['file_title_image'])) {
unlink('images/' . $existing_file_in_category['file_title_image']);
}
if (file_exists('images/' . $existing_file_in_category['file_image'])) {
unlink('images/' . $existing_file_in_category['file_image']);
}
}
}
}

//Remove uploaded file, image and screenshots.

//Insert file path into DB.

private function insertFileNameDb() {
$conn = $this->db->connect();
$new_file_name = $this->createNewFileName();
$insert_new_file = $conn->prepare("UPDATE files SET file_download = ? WHERE file_id = ?");
$insert_new_file->bind_param('si', $new_file_name, $this->file_id);
$result = $insert_new_file->execute();
$this->db->closeConnection();
if ($result) {
return $new_file_name;
} else {
return false;
}
}

//Insert file path into DB.

//Insert image path into DB.

private function insertImageNameDb() {
$conn = $this->db->connect();
$new_image_name = $this->createNewImageName();
$insert_image = $conn->prepare("UPDATE files SET file_title_image = ? WHERE file_id = ?");
$insert_image->bind_param('si', $new_image_name, $this->file_id);
$result = $insert_image->execute();
$this->db->closeConnection();
if ($result) {
return $new_image_name;
} else {
return false;
}
}

//Insert image path into DB.

//Upload a file.

private function storeFile() {
$existing_file = $this->checkIfFileExistsDb();
if ($existing_file) {
if (file_exists('files/' . $existing_file)) {
unlink('files/' . $existing_file);
}
}
$file_tmp_name = $this->file['tmp_name'];
$new_file_name = $this->insertFileNameDb();
if ($new_file_name && move_uploaded_file ($file_tmp_name , 'files/'. $new_file_name)) {
return true;
} else {
return false;
}
}

//Upload a file.

//Upload an image.

private function storeImage() {
$existing_image = $this->checkIfImageExistsDb();
if ($existing_image) {
if (file_exists('images/' . $existing_image)) {
unlink('images/' . $existing_image);
}
}
$image_tmp_name = $this->image['tmp_name'];
$new_image_name = $this->insertImageNameDb();
if ($new_image_name && move_uploaded_file ($image_tmp_name , 'images/'. $new_image_name)) {
return true;
} else {
return false;
}
}

//Upload an image.

//Upload multiple screenshots.

private function storeScreenshots() {
$screenshot_names = array();
foreach ($this->screenshots['tmp_name'] as $key => $tmp_name) {
$new_screenshot_name = uniqid(). ".". pathinfo($this->screenshots['name'][$key], PATHINFO_EXTENSION);
if (move_uploaded_file ($tmp_name , 'images/'. $new_screenshot_name)) {
$screenshot_names[] = $new_screenshot_name;
}
}
return $screenshot_names;
}

//Upload multiple screenshots.

//Saving the image paths of the respective screenshots.

private function insertScreenshotsNameDb($screenshot_names) {
$conn = $this->db->connect();
$result = true;
foreach ($screenshot_names as $screenshot_name) {
$insert_screenshot = $conn->prepare("INSERT INTO file_images(file_image, file_id) VALUES(?, ?)");
$insert_screenshot->bind_param('si', $screenshot_name, $this->file_id);
if (! $insert_screenshot->execute()) {
$result = false;
break;
}
}
$this->db->closeConnection();
return $result;
}

//Saving the image paths of the respective screenshots.

//Upload.

public function uploadFile() {
$this->validateFile();
if ($this->error_container->hasErrors()) {
return false;
} else {
$result = $this->storeFile();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while uploading file.");
}
}
}

public function uploadImage() {
$this->validateImage();
if ($this->error_container->hasErrors()) {
return false;
} else {
$result = $this->storeImage();
if ($result !== false) {
return $result;
} else {
throw new Exception("A critical error occurred while uploading image.");
}
}
}

public function uploadScreenshots() {
$this->validateScreenshots();
if ($this->error_container->hasErrors()) {
return false;
} else {
$screenshot_names = $this->storeScreenshots();
$this->insertScreenshotsNameDb($screenshot_names);
return true;
}
}


//Upload.

}
