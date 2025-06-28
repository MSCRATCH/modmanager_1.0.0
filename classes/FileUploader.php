<?php

//FileUploader.php [Class to control uploads.]
//pathologicalplay [MMXXV]

class FileUploader {

private $db;
private $file;
private $image;
private $screenshots = array();
private $enable_screenshots;
private $enable_readme;
private $file_id;
private $allowed_file_extensions = array("zip", "rar");
private $allowed_file_mime_types = array('application/zip', 'application/x-zip', 'application/x-zip-compressed', 'application/x-compressed', 'application/x-rar', 'application/x-rar-compressed', 'application/vnd.rar');
private $maximum_file_size = 250 * 1024 * 1024;
private $allowed_image_extensions = array("jpg", "jpeg", "png");
private $allowed_image_mime_types = array('image/jpeg', 'image/png');
private $maximum_image_size = 2 * 1024 * 1024;
private $error_container;
private $file_manager;
private $readme_manager;

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

public function enableScreenshots($enable_screenshots) {
$this->enable_screenshots = $enable_screenshots;
}

public function enableReadme($enable_readme) {
$this->enable_readme = $enable_readme;
}

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setErrorContainer(ErrorContainer $error_container) {
$this->error_container = $error_container;
}

public function setFileManager(FileManager $file_manager) {
$this->file_manager = $file_manager;
}

public function setReadmeManager(ReadmeManager $readme_manager) {
$this->readme_manager = $readme_manager;
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
$this->error_container->addError('Error uploading screenshot, invalid image size.');
}
$screenshot_name = $this->screenshot['name'];
$screenshot_extension = pathinfo($screenshot_name, PATHINFO_EXTENSION);
if (! in_array(strtolower($screenshot_extension), $this->allowed_image_extensions)) {
$this->error_container->addError('Error uploading screenshot, invalid image extension. Only JPG, JPEG or PNG allowed.');
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

private function uploadFile() {
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

private function uploadImage() {
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

private function uploadScreenshots() {
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

public function upload() {

$this->file_manager->setValidateDescriptionCreateFile();
$this->validateFile();
$this->validateImage();

if ($this->enable_readme === 1) {
$this->readme_manager->setCheckIfReadmeIsEmpty();
}

if ($this->enable_screenshots === 1) {
$this->validateScreenshots();
}

if ($this->error_container->hasErrors()) {
return ['success' => false, 'error' => 'validation error'];
} else {
if ($new_file_id = $this->file_manager->createFile()) {
$this->setFileId($new_file_id);
if ($this->enable_readme === 1) {
$this->readme_manager->setFileId($new_file_id);
}
} else {
throw new Exception("A critical error occurred while creating the file description.");
}

if (! $this->uploadFile()) {
throw new Exception("A critical error occurred while uploading file.");
}

if (! $this->uploadImage()) {
throw new Exception("A critical error occurred while uploading image.");
}

if ($this->enable_readme === 1) {
$this->readme_manager->createReadme();
}

if ($this->enable_screenshots === 1) {
$screenshot_names = $this->uploadScreenshots();
if (empty($screenshot_names)) {
throw new Exception("A critical error occurred while uploading screenshots.");
}
if (! $this->insertScreenshotsNameDb($screenshot_names)) {
throw new Exception("A critical error occurred while uploading screenshots.");
}
}
return ['success' => true, 'new_file_id' => $new_file_id];
}
}

//Upload.

}
