<?php

//category_management.php [Category management.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

//Remove a category, security question.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_category'])) {
if ($csrfToken->validateToken('remove_category', $_POST['csrf_token'])) {

$category_id_remove_category_form = '';
if (isset($_POST['category_id_remove_category_form'])) {
$category_id_remove_category_form = (INT) $_POST['category_id_remove_category_form'];
}

include 'templates/messages/message_remove_category.php';
require_once 'includes/footer.php';
exit();
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a category, security question.

//Remove a category.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_category_confirm'])) {
if ($csrfToken->validateToken('remove_category_confirm', $_POST['csrf_token'])) {

$category_id_remove_category_confirm_form = '';
if (isset($_POST['category_id_remove_category_confirm_form'])) {
$category_id_remove_category_confirm_form = (INT) $_POST['category_id_remove_category_confirm_form'];
}

try {
$file_updater = new FileUpdater($db);
$file_updater->setCategoryId($category_id_remove_category_confirm_form);
$file_updater->removeAllFilesFromCategory();
$category_manager = new CategoryManager($db);
$category_manager->setCategoryId($category_id_remove_category_confirm_form);
$result = $category_manager->removeCategory();
if ($result === true) {
$message = new Message('The Category has been successfully removed.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a category.

//Save a category.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['submit_category'])) {
if ($csrfToken->validateToken('submit_category', $_POST['csrf_token'])) {

$category_name_form = '';
if (isset($_POST['category_name_form'])) {
$category_name_form = trim($_POST['category_name_form']);
}

$category_description_form = '';
if (isset($_POST['category_description_form'])) {
$category_description_form = trim($_POST['category_description_form']);
}

try {
$category_manager = new CategoryManager($db);
$category_manager->setCategoryName($category_name_form);
$category_manager->setCategoryDescription($category_description_form);
$result = $category_manager->createCategory();
if ($result === true) {
$message = new Message('The category has been successfully created.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Save a category.

//Update a category.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_category'])) {
if ($csrfToken->validateToken('update_category', $_POST['csrf_token'])) {

$category_id_remove_update_form = '';
if (isset($_POST['category_id_remove_update_form'])) {
$category_id_remove_update_form = (INT) $_POST['category_id_remove_update_form'];
}

$category_name_update_form = '';
if (isset($_POST['category_name_update_form'])) {
$category_name_update_form = trim($_POST['category_name_update_form']);
}

$category_description_update_form = '';
if (isset($_POST['category_description_update_form'])) {
$category_description_update_form = trim($_POST['category_description_update_form']);
}

try {
$category_manager = new CategoryManager($db);
$category_manager->setCategoryId($category_id_remove_update_form);
$category_manager->setCategoryName($category_name_update_form);
$category_manager->setCategoryDescription($category_description_update_form);
$result = $category_manager->updateCategory();
if ($result === true) {
$message = new Message('The category has been updated successfully.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_category_management.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=category_management', 'Return to category management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Update a category.

//Output of the categories.

$category_manager = new CategoryManager($db);
$categories = $category_manager->showCategories();
if ($categories === false) {
$message = new Message('Categories must first be created before files can be added.');
echo $message->renderMessage();
}
include 'templates/category_management_template.php';

//Output of the categories.

?>
