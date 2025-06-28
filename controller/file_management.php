<?php

//file_management.php [Management of files.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

//Remove a file, security question.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_file'])) {
if ($csrfToken->validateToken('remove_file', $_POST['csrf_token'])) {
$file_id_remove_file_form = '';
if (isset($_POST['file_id_remove_file_form'])) {
$file_id_remove_file_form = (INT) $_POST['file_id_remove_file_form'];
}
include 'templates/messages/message_remove_file.php';
require_once 'includes/footer.php';
exit();
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=file_management', 'Return to file management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a file, security question.

//Remove a file.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_file_confirm'])) {
if ($csrfToken->validateToken('remove_file_confirm', $_POST['csrf_token'])) {

$file_id_remove_file_confirm_form = '';
if (isset($_POST['file_id_remove_file_confirm_form'])) {
$file_id_remove_file_confirm_form = (INT) $_POST['file_id_remove_file_confirm_form'];
}

try {
$file_updater = new FileUpdater($db);
$file_updater->setFileId($file_id_remove_file_confirm_form);
$file_updater->removeExistingData();
$file_manager = new FileManager($db);
$file_manager->setFileId($file_id_remove_file_confirm_form);
$result = $file_manager->removeFile();
if ($result === true) {
$message = new Message('The file has been successfully removed.', 'index.php?section=file_management', 'Return to file management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=file_management', 'Return to file management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a file.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$file_manager = new FileManager($db);
$total_records = $file_manager->getNumberOfAllFiles();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->isValidPageNumber();
$offset = $pagination->getOffset();

//Pagination.

$file_manager->setEntriesPerPage($entries_per_page);
$file_manager->setOffset($offset);
$files = $file_manager->getAllFiles();

include 'templates/file_management_template.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}


?>
