<?php

//logout.php [Logout the respective user.]

if (! Auth::isLoggedIn()) {
header('Location: index.php');
}

unset($_SESSION['logged_in']['username']);
unset($_SESSION['logged_in']['user_level']);
unset($_SESSION['logged_in']['user_id']);
require_once 'includes/header.php';
$message = new Message('You have been successfully logged out.', 'index.php?section=categories', 'Back to homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();

?>
