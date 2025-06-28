<?php

//item.php [Output of the full file view.]

require_once 'includes/header.php';

$csrfToken = new CsrfToken($_SESSION);

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
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if the file exists.

//Remove a comment.

if (Auth::isAdministrator()) {
if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_comment'])) {
if ($csrfToken->validateToken('remove_comment', $_POST['csrf_token'])) {

$file_comment_id_remove_comment = '';
if (isset($_POST['file_comment_id_remove_comment'])) {
$file_comment_id_remove_comment = (INT) $_POST['file_comment_id_remove_comment'];
}

try {
$comment_manager = new CommentManager($db);
$comment_manager->setFileCommentId($file_comment_id_remove_comment);
if ($comment_manager->removeComment()) {
$message = new Message('The comment has been successfully removed.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_view_item.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}
}

//Remove a comment.

//Add a file to the GameLog.

if (Auth::isLoggedIn()) {
if (isset($_POST['csrf_token'])) {
if (isset($_POST['add_to_game_log'])) {
if ($csrfToken->validateToken('add_to_game_log', $_POST['csrf_token'])) {
$user_id = Auth::getUserId();
try {
$game_log = new GameLog($db);
$game_log->setFileId($file_id_get);
$game_log->setUserId($user_id);
if ($game_log->addToGameLog()) {
$message = new Message('Added to GameLog successfully.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_view_item.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}
}

//Add a file to the GameLog.

//Remove a file from the GameLog.

if (Auth::isLoggedIn()) {
if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_from_game_log'])) {
if ($csrfToken->validateToken('remove_from_game_log', $_POST['csrf_token'])) {
$user_id = Auth::getUserId();
try {
$game_log = new GameLog($db);
$game_log->setFileId($file_id_get);
$game_log->setUserId($user_id);
if ($game_log->removeFromGameLog()) {
$message = new Message('Successfully removed from GameLog.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_view_item.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}
}

//Remove a file from the GameLog.

//Adding a like.

if (Auth::isLoggedIn()) {
if (isset($_POST['csrf_token'])) {
if (isset($_POST['add_like'])) {
if ($csrfToken->validateToken('add_like', $_POST['csrf_token'])) {
$user_id = Auth::getUserId();
try {
$like_manager = new LikeManager($db);
$like_manager->setFileId($file_id_get);
$like_manager->setUserId($user_id);
if ($like_manager->addLike()) {
$message = new Message('Your like has been successfully added.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_view_item.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}
}

//Adding a like.

//Remove a like.

if (Auth::isLoggedIn()) {
if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_like'])) {
if ($csrfToken->validateToken('remove_like', $_POST['csrf_token'])) {
$user_id = Auth::getUserId();
try {
$like_manager = new LikeManager($db);
$like_manager->setFileId($file_id_get);
$like_manager->setUserId($user_id);
if ($like_manager->removeLike()) {
$message = new Message('Your like has been successfully removed.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_view_item.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}
}

//Remove a like.

//Saving a comment.

if (Auth::isLoggedIn()) {
if (isset($_POST['csrf_token'])) {
if (isset($_POST['create_comment'])) {
if ($csrfToken->validateToken('create_comment', $_POST['csrf_token'])) {
$user_id = Auth::getUserId();

$file_comment_form = '';
if (isset($_POST['file_comment_form'])) {
$file_comment_form = trim($_POST['file_comment_form']);
}

try {
$comment_manager = new CommentManager($db);
$comment_manager->setFileId($file_id_get);
$comment_manager->setCommentText($file_comment_form);
$comment_manager->setUserId($user_id);
if ($comment_manager->createComment()) {
$message = new Message('Your comment has been added successfully.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_view_item.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=item&id='. sanitize($file_id_get), 'Return to the accessed file');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}
}

//Saving a comment.

//Output of the file view.

$file_manager = new FileManager($db);
$file_manager->setFileId($file_id_get);
$file_description = $file_manager->getFileDescription();

$image_manager = new ImageManager($db);
$image_manager->setFileId($file_id_get);
$file_images = $image_manager->getImages();

$readme_manager = new ReadmeManager($db);
$readme_manager->setFileId($file_id_get);
$readme = $readme_manager->checkFileReadme();

$comment_manager = new CommentManager($db);
$comment_manager->setFileId($file_id_get);
$file_comments = $comment_manager->getComments();

$user_id = Auth::getUserId();
$game_log = new GameLog($db);
$game_log->setFileId($file_id_get);
$game_log_count_for_file = $game_log->getFileGameLogStats();

$like_manager = new LikeManager($db);
$like_manager->setFileId($file_id_get);
$like_count_for_file = $like_manager->getFileLikes();

if (Auth::isLoggedIn()) {
$game_log->setUserId($user_id);
$is_in_gameLog = $game_log->checkGameLog();

$like_manager->setUserId($user_id);
$is_liked = $like_manager->checkIfUserLiked();
}

include 'templates/item_template.php';


//Output of the file view.

?>
