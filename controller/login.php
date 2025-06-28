<?php

//login.php [Login the respective user.]

if (Auth::isLoggedIn()) {
header('Location: index.php');
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';


if (isset($_POST['csrf_token'])) {
if (isset($_POST['login'])) {
if ($csrfToken->validateToken('login', $_POST['csrf_token'])) {

$username_form = '';
if (isset($_POST['username_form'])) {
$username_form = trim($_POST['username_form']);
}

$user_password_form = '';
if (isset($_POST['user_password_form'])) {
$user_password_form = trim($_POST['user_password_form']);
}

try {
$login = new User($db);
$login->setUsername($username_form);
$login->setUserPassword($user_password_form);

if ($login->login()) {
$message = new Message('You have been successfully logged in.', 'index.php?section=categories', 'Back to homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_login.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=login', 'Return to login');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

require_once 'templates/login_form_template.php';
?>
