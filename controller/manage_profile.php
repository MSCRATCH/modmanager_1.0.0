<?php

//manage_profile.php [Edit the respective user profile.]

if (! Auth::isLoggedIn()) {
header('Location: index.php?section=login');
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

$user_id_session = Auth::getUserId();

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_user_profile_description'])) {
if ($csrfToken->validateToken('update_user_profile_description', $_POST['csrf_token'])) {

$user_profile_description_form = '';
if (isset($_POST['user_profile_description_form'])) {
$user_profile_description_form = trim($_POST['user_profile_description_form']);
}

try {
$profile_manager = new ProfileManager($db);
$profile_manager->setUserId($user_id_session);
$profile_manager->setUserProfileDescription($user_profile_description_form);
if ($profile_manager->updateUserProfile()) {
$message = new Message('The profile has been successfully updated.', 'index.php?section=manage_profile', 'Back to profile settings');
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
$message = new Message('The session has expired for security reasons.', 'index.php?section=manage_profile', 'Back to profile settings');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

try {
$profile_manager = new ProfileManager($db);
$profile_manager->setUserId($user_id_session);
$user_profile_data = $profile_manager->getUserProfile();
include 'templates/manage_profile_template.php';
} catch (Exception $e) {
include 'templates/messages/message.php';
}


?>
