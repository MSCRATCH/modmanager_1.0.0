<?php

//create_file.php [Creating and uploading new files.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

$error_container = new ErrorContainer();

//Create a new file description. Upload the file, cover image, and screenshots.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['submit_file'])) {
if ($csrfToken->validateToken('submit_file', $_POST['csrf_token'])) {

$file_name_form = '';
if (isset($_POST['file_name_form'])) {
$file_name_form = trim($_POST['file_name_form']);
}

$file_author_form = '';
if (isset($_POST['file_author_form'])) {
$file_author_form = trim($_POST['file_author_form']);
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

$enable_screenshots_form = '';
if (isset($_POST['enable_screenshots_form'])) {
$enable_screenshots_form = (INT) $_POST['enable_screenshots_form'];
}

$readme_file_form = '';
if (isset($_POST['readme_file_form'])) {
$readme_file_form = $_POST['readme_file_form'];
}

$enable_readme_form = '';
if (isset($_POST['enable_readme_form'])) {
$enable_readme_form = (INT) $_POST['enable_readme_form'];
}

try {

//Create a new file description.

$file_manager = new FileManager($db);
$file_manager->setErrorContainer($error_container);
$file_manager->setFileName($file_name_form);
$file_manager->setFileAuthor($file_author_form);
$file_manager->setFileDescription($file_description_form);
$file_manager->setFileType($file_type_form);
$file_manager->setCategoryId($category_id_form);

//Create a new file description.

//Create a readme if enabled.

if ($enable_readme_form === 1) {
$readme_manager = new ReadmeManager($db);
$readme_manager->setErrorContainer($error_container);
$readme_manager->setFileReadmeContent($readme_file_form);
}

//Create a readme if enabled.

//Upload file, cover image and screenshots.

$file_uploader = new FileUploader($db);
$file_uploader->setErrorContainer($error_container);
$file_uploader->setFileManager($file_manager);
if ($enable_readme_form === 1) {
$file_uploader->setReadmeManager($readme_manager);
}
$file_uploader->enableScreenshots($enable_screenshots_form);
$file_uploader->enableReadme($enable_readme_form);
$file_uploader->setFile($_FILES);
$file_uploader->setImage($_FILES);
$file_uploader->setScreenshots($_FILES);

//Upload file, cover image and screenshots.

//Execute.

$result = $file_uploader->upload();
if ($result['success'] && is_numeric($result['new_file_id'])) {
$message = new Message('The file was added successfully.', 'index.php?section=item&id='. sanitize($result['new_file_id']), 'Show new file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Execute.

} catch (Exception $e) {
include 'templates/messages/message_create_file.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=create_file', 'Return to create file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Create a new file description. Upload the file, cover image, and screenshots.

//Output the categories for select element and abort if no category is present.

$category_manager = new CategoryManager($db);
$categories = $category_manager->showCategories();
if ($categories === false) {
$message = new Message('Categories must first be created before files can be added.');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
include 'templates/create_file_template.php';
}

//Output the categories for select element and abort if no category is present.

?>
