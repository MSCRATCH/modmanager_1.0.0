<?php

//readme.php [Output of the respective readme.]

require_once 'includes/header.php';

//ID of the file.

$file_id_get = '';
if (isset($_GET['id'])) {
$file_id_get = (INT) $_GET['id'];
}

//ID of the file.

//Check if the file exists.

$file_manager = new FileManager($db);
$file_manager->setFileId($file_id_get);
if ($file_manager->validateIdOfFile() === false) {
$message = new Message('The readme you are looking for does not exist.', 'index.php?section=categories', 'Return to the homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if the file exists.

$readme_manager = new ReadmeManager($db);
$readme_manager->setFileId($file_id_get);
$readme = $readme_manager->getFileReadme();
if ($readme === false) {
$message = new Message('The readme you are looking for does not exist.', 'index.php?section=categories', 'Return to the homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
include 'templates/readme_template.php';
}

?>
