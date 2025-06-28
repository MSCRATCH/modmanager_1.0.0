<?php

//news_management.php [Management of posts (news).]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

//Remove a post, security question.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_news_post'])) {
if ($csrfToken->validateToken('remove_news_post', $_POST['csrf_token'])) {

$news_id_remove_news_form = '';
if (isset($_POST['news_id_remove_news_form'])) {
$news_id_remove_news_form = (INT) $_POST['news_id_remove_news_form'];
}

include 'templates/messages/message_remove_news.php';
require_once 'includes/footer.php';
exit();
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=news_management', 'Return to news management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a post, security question.

//Remove a post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['remove_news_confirm'])) {
if ($csrfToken->validateToken('remove_news_confirm', $_POST['csrf_token'])) {

$news_id_remove_news_confirm_form = '';
if (isset($_POST['news_id_remove_news_confirm_form'])) {
$news_id_remove_news_confirm_form = (INT) $_POST['news_id_remove_news_confirm_form'];
}

try {
$news_manager = new NewsManager($db);
$news_manager->setNewsPostId($news_id_remove_news_confirm_form);
$result = $news_manager->removeNewsPost();
if ($result === true) {
$message = new Message('The news post has been successfully removed.', 'index.php?section=news_management', 'Return to news management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_news_management.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=news_management', 'Return to news management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Remove a post.

//Create a new post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['submit_news_post'])) {
if ($csrfToken->validateToken('submit_news_post', $_POST['csrf_token'])) {

$news_post_title_form = '';
if (isset($_POST['news_post_title_form'])) {
$news_post_title_form = trim($_POST['news_post_title_form']);
}

$news_post_text_form = '';
if (isset($_POST['news_post_text_form'])) {
$news_post_text_form = trim($_POST['news_post_text_form']);
}

if (Auth::isLoggedIn() && Auth::isAdministrator()) {
$user_id_news = Auth::getUserId();
}

try {
$news_manager = new NewsManager($db);
$news_manager->setNewsPostTitle($news_post_title_form);
$news_manager->setNewsPostText($news_post_text_form);
$news_manager->setUserId($user_id_news);
$result = $news_manager->createNewsPost();
if ($result === true) {
$message = new Message('The news post has been successfully created.', 'index.php?section=news_management', 'Return to news management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
} catch (Exception $e) {
include 'templates/messages/message_news_management.php';
require_once 'includes/footer.php';
exit();
}
} else {
$message = new Message('The session has expired for security reasons.', 'index.php?section=news_management', 'Return to news management');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Create a new post.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

$news_manager = new NewsManager($db);
$total_records = $news_manager->getNumberOfNewsPosts();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->isValidPageNumber();
$offset = $pagination->getOffset();

//Pagination.

$news_manager->setEntriesPerPage($entries_per_page);
$news_manager->setOffset($offset);
$news = $news_manager->getNewsPosts();

include 'templates/news_management_template.php';



?>
