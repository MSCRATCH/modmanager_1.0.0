<?php

//ImageManager.php [Class to manage the file_images table.]
//file_images.
//pathologicalplay [MMXXV]

class ImageManager {

private $db;
private $file_id;
private $file_image_id;


function __construct(Dbh $db) {
$this->db = $db;
}

//Set methods.

public function setFileId($file_id) {
$this->file_id = $file_id;
}

public function setFileImageId($file_image_id) {
$this->file_image_id = $file_image_id;
}

//Set methods.

//Output of the images associated with the file (file_images). [controller->item.php]

private function getImagesDb() {
$conn = $this->db->connect();
$get_images = $conn->prepare("SELECT file_image_id, file_image FROM file_images WHERE file_id = ?");
$get_images->bind_param('i', $this->file_id);
$get_images->execute();
$result = $get_images->get_result()->fetch_all(MYSQLI_ASSOC);
$this->db->closeConnection();
return $result ?: false;
}

public function getImages() {
$result = $this->getImagesDb();
if ($result !== false && ! empty($result)) {
return $result;
} else {
return false;
}
}

//Output of the images associated with the file (file_images). [controller->item.php]

//Remove a screenshot (file_images). [controller->edit_file.php]

private function removeImageDb() {
$conn = $this->db->connect();
$remove_image = $conn->prepare("DELETE FROM file_images WHERE file_image_id = ? LIMIT 1");
$remove_image->bind_param('i', $this->file_image_id);
$result = $remove_image->execute();
$this->db->closeConnection();
if ($result) {
return true;
} else {
return false;
}
}

public function removeImage() {
if ($this->removeImageDb()) {
return true;
} else {
throw new Exception("A critical error occurred while removing a screenshot.");
}
}

//Remove a screenshot (file_images). [controller->edit_file.php]

}
