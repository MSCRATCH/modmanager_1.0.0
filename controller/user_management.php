<?php

//user_management.php [User management.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

//Update user level.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_user_level'])) {
if ($csrfToken->validateToken('update_user_level', $_POST['csrf_token'])) {

$user_id_user_level_form = '';
if (isset($_POST['user_id_user_level_form'])) {
$user_id_user_level_form = (INT) $_POST['user_id_user_level_form'];
}

$user_level_form = '';
if (isset($_POST['user_level_form'])) {
$user_level_form = trim($_POST['user_level_form']);
}

try {
$user = new User($db);
$user->setUserId($user_id_user_level_form);
$user->setUserLevel($user_level_form);
if ($user->updateUserLevel()) {
$message = new Message('The user level has been successfully updated.', 'index.php?section=user_management', 'Return to user management');
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
$message = new Message('The session has expired for security reasons.', 'index.php?section=user_management', 'Return to user management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Update user level.

//Remove a user, security question.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_user'])) {
if ($csrfToken->validateToken('remove_user', $_POST['csrf_token'])) {
$user_id_remove_user_form = '';
if (isset($_POST['user_id_remove_user_form'])) {
$user_id_remove_user_form = (INT) $_POST['user_id_remove_user_form'];
}
include 'templates/messages/message_remove_user.php';
require_once 'includes/footer.php';
exit();
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=user_management', 'Return to user management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a user, security question.

//Remove a user.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_user_confirm'])) {
if ($csrfToken->validateToken('remove_user_confirm', $_POST['csrf_token'])) {

$user_id_remove_user_confirm_form = '';
if (isset($_POST['user_id_remove_user_confirm_form'])) {
$user_id_remove_user_confirm_form = (INT) $_POST['user_id_remove_user_confirm_form'];
}

try {
$user = new User($db);
$user->setUserId($user_id_remove_user_confirm_form);
if ($user->removeUser()) {
$message = new Message('The user has been successfully removed.', 'index.php?section=user_management', 'Return to user management');
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
$message = new Message('The session has expired for security reasons.', 'index.php?section=user_management', 'Return to user management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a user.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

try {
$user = new User($db);
$total_records = $user->getNumberOfUsers();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->isValidPageNumber();
$offset = $pagination->getOffset();

//Pagination.

$user->setEntriesPerPage($entries_per_page);
$user->setOffset($offset);
$users = $user->getAllUsers();

include 'templates/user_management_template.php';

} catch (Exception $e) {
include 'templates/messages/message.php';
}

?>
