<?php

//download.php [Output of the download link.]

$csrfToken = new CsrfToken($_SESSION);

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
$message = new Message('The file you are looking for does not exist.', 'index.php?section=categories', 'Return to the homepage');
require_once 'includes/header.php';
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if the file exists.

//Output the file path.

$file_manager = new FileManager($db);
$file_manager->setFileId($file_id_get);
$result = $file_manager->getDownloadDescription();

//Output the file path.

//Download.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['download_item'])) {
if ($csrfToken->validateToken('download_item', $_POST['csrf_token'])) {
header('Location: files/'. sanitize($result['file_download']));
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
require_once 'includes/header.php';
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Download.

require_once 'includes/header.php';

//Calculating the file size.

$file_path = 'files/' . sanitize($result['file_download']);
if (file_exists($file_path)) {
$file_size = filesize($file_path);
include 'templates/download_template.php';
} else {
$message = new Message('The requested file does not exist.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
require_once 'includes/header.php';
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Calculating the file size.


?>
