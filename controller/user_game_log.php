<?php

//user_game_log.php [Output of the respective GameLog.]

require_once 'includes/header.php';

//User ID.

$user_id_get = '';
if (isset($_GET['id'])) {
$user_id_get = (INT) $_GET['id'];
}

//User ID.

//Check if a user exists.

$user = new User($db);
$user->setUserId($user_id_get);
if ($user->validateIdOfUser() === false) {
$message = new Message('The GameLog of the user you are looking for does not exist.', 'index.php?section=categories', 'Return to the homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if a user exists.

//Specify how many records should be displayed on each page.

$entries_per_page = 50;

//Specify how many records should be displayed on each page.

$game_log = new GameLog($db);
$game_log->setUserId($user_id_get);
$total_records = $game_log->getNumberOfGameLog();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->isValidPageNumber();
$offset = $pagination->getOffset();

//Pagination.

$game_log->setEntriesPerPage($entries_per_page);
$game_log->setOffset($offset);
$result = $game_log->getUserGameLog();
if ($result === false) {
$message = new Message('The user has not added anything to his game log yet.');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
include 'templates/user_game_log_template.php';
}

?>
