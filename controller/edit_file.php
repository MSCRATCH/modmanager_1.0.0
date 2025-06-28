<?php

//edit_file.php [Editing a file.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

$error_container = new ErrorContainer();

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

//Edit the file description.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['submit_description'])) {
if ($csrfToken->validateToken('submit_description', $_POST['csrf_token'])) {

$file_name_form = '';
if (isset($_POST['file_name_form'])) {
$file_name_form = trim($_POST['file_name_form']);
}

$file_author_form = '';
if (isset($_POST['file_author_form'])) {
$file_author_form = trim($_POST['file_author_form']);
}

$file_download_form = '';
if (isset($_POST['file_download_form'])) {
$file_download_form = trim($_POST['file_download_form']);
}

$file_title_image_form = '';
if (isset($_POST['file_title_image_form'])) {
$file_title_image_form = trim($_POST['file_title_image_form']);
}

$file_description_form = '';
if (isset($_POST['file_description_form'])) {
$file_description_form = trim($_POST['file_description_form']);
}

$category_id_form = '';
if (isset($_POST['category_id_form'])) {
$category_id_form = (INT) $_POST['category_id_form'];
}

$file_type_form = '';
if (isset($_POST['file_type_form'])) {
$file_type_form = trim($_POST['file_type_form']);
}

try {
$file_manager = new FileManager($db);
$file_manager->setErrorContainer($error_container);
$file_manager->setFileId($file_id_get);
$file_manager->setFileName($file_name_form);
$file_manager->setFileAuthor($file_author_form);
$file_manager->setFileDownload($file_download_form);
$file_manager->setFileTitleImage($file_title_image_form);
$file_manager->setFileDescription($file_description_form);
$file_manager->setFileType($file_type_form);
$file_manager->setCategoryId($category_id_form);
$result = $file_manager->updateFile();
if ($result === true) {
$message = new Message('The file description was updated successfully.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Edit the file description.


//Overwrite an existing file.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_file'])) {
if ($csrfToken->validateToken('update_file', $_POST['csrf_token'])) {
try {
$file_updater = new FileUpdater($db);
$file_updater->setErrorContainer($error_container);
$file_updater->setFileId($file_id_get);
$file_updater->setFile($_FILES);
$result = $file_updater->uploadFile();
if ($result === true) {
$message = new Message('The file was updated successfully.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Overwrite an existing file.

//Overwrite an existing cover image.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_image'])) {
if ($csrfToken->validateToken('update_image', $_POST['csrf_token'])) {
try {
$file_updater = new FileUpdater($db);
$file_updater->setErrorContainer($error_container);
$file_updater->setFileId($file_id_get);
$file_updater->setImage($_FILES);
$result = $file_updater->uploadImage();
if ($result === true) {
$message = new Message('The image was updated successfully.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Overwrite an existing cover image.

//Removing screenshots.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_screenshot'])) {
if ($csrfToken->validateToken('remove_screenshot', $_POST['csrf_token'])) {

$file_image_id = '';
if (isset($_POST['remove_screenshot'])) {
$file_image_id = (INT) $_POST['remove_screenshot'];
}

try {
$image_manager = new ImageManager($db);
$image_manager->setFileImageId($file_image_id);
$result = $image_manager->removeImage();
if ($result === true) {
$message = new Message('The screenshot was removed successfully.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Removing screenshots.

//Re-adding screenshots.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_screenshots'])) {
if ($csrfToken->validateToken('update_screenshots', $_POST['csrf_token'])) {
try {
$file_updater = new FileUpdater($db);
$file_updater->setErrorContainer($error_container);
$file_updater->setFileId($file_id_get);
$file_updater->setScreenshots($_FILES);
$result = $file_updater->uploadScreenshots();
if ($result === true) {
$message = new Message('The screenshots were added successfully.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Re-adding screenshots.

//Creating a Readme.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['create_readme'])) {
if ($csrfToken->validateToken('create_readme', $_POST['csrf_token'])) {

$file_readme_content_form = '';
if (isset($_POST['file_readme_content_form'])) {
$file_readme_content_form = trim($_POST['file_readme_content_form']);
}

try {
$readme_manager = new ReadmeManager($db);
$readme_manager->setErrorContainer($error_container);
$readme_manager->setFileId($file_id_get);
$readme_manager->setFileReadmeContent($file_readme_content_form);
$readme_manager->setCheckIfReadmeIsEmpty();
$result = $readme_manager->createReadme();
if ($result === true) {
$message = new Message('The readme has been successfully added.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Creating a Readme.

//Update a readme.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_readme'])) {
if ($csrfToken->validateToken('update_readme', $_POST['csrf_token'])) {

$file_readme_content_form = '';
if (isset($_POST['file_readme_content_form'])) {
$file_readme_content_form = trim($_POST['file_readme_content_form']);
}

try {
$readme_manager = new ReadmeManager($db);
$readme_manager->setErrorContainer($error_container);
$readme_manager->setFileId($file_id_get);
$readme_manager->setFileReadmeContent($file_readme_content_form);
$readme_manager->setCheckIfReadmeIsEmpty();
$result = $readme_manager->updateReadme();
if ($result === true) {
$message = new Message('The readme has been successfully updated.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Update a readme.

//Removing a readme.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_readme'])) {
if ($csrfToken->validateToken('remove_readme', $_POST['csrf_token'])) {
try {
$readme_manager = new ReadmeManager($db);
$readme_manager->setFileId($file_id_get);
$result = $readme_manager->removeReadme();
if ($result === true) {
$message = new Message('The readme has been successfully removed.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_edit_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Removing a readme.

$category_manager = new CategoryManager($db);
$categories = $category_manager->showCategories();
if ($categories === false) {
$message = new Message('Categories must first be created before files can be added.');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
$file_manager = new FileManager($db);
$file_manager->setFileId($file_id_get);
$file = $file_manager->getFileDescription();
$image_manager = new ImageManager($db);
$image_manager->setFileId($file_id_get);
$file_images = $image_manager->getImages();
$readme_manager = new ReadmeManager($db);
$readme_manager->setFileId($file_id_get);
$readme = $readme_manager->checkFileReadme();
}

include 'templates/edit_file_template.php';

?>
