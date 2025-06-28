<?php

//register.php [Registering a new user.]

if (Auth::isLoggedIn()) {
header('Location: index.php');
}

require_once 'includes/header.php';

$csrfToken = new CsrfToken($_SESSION);

$error_container = new ErrorContainer();

if (isset($_POST['csrf_token'])) {
if (isset($_POST['register'])) {
if ($csrfToken->validateToken('register', $_POST['csrf_token'])) {

$username_form = '';
if (isset($_POST['username_form'])) {
$username_form = trim($_POST['username_form']);
}

$user_password_form = '';
if (isset($_POST['password_form'])) {
$user_password_form = trim($_POST['password_form']);
}

$user_password_confirm_form = '';
if (isset($_POST['user_password_confirm_form'])) {
$user_password_confirm_form = trim($_POST['user_password_confirm_form']);
}

$user_email_form = '';
if (isset($_POST['user_email_form'])) {
$user_email_form = trim($_POST['user_email_form']);
}

$security_question_answer_form = '';
if (isset($_POST['security_question_answer_form'])) {
$security_question_answer_form = trim($_POST['security_question_answer_form']);
}

try {
$register = new User($db);
$register->setErrorContainer($error_container);
$register->setUsername($username_form);
$register->setUserPassword($user_password_form);
$register->setUserPasswordConfirm($user_password_confirm_form);
$register->setUserEmail($user_email_form);
$register->setSecurityQuestionAnswer($security_question_answer_form);

if ($register->register()) {
$message = new Message('You have been successfully registered.', 'index.php?section=categories', 'Back to homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_register.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=register', 'Return to register');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

require_once 'templates/register_form_template.php';

?>
