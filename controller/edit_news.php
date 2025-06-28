<?php

//edit_news.php [Editing a post.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

$csrfToken = new CsrfToken($_SESSION);

require_once 'includes/header.php';

//ID of the post.

$news_post_id_get = '';
if (isset($_GET['id'])) {
$news_post_id_get = (INT) $_GET['id'];
}

//ID of the post.

//Check if the file exists.

$news_manager = new NewsManager($db);
$news_manager->setNewsPostId($news_post_id_get);
if ($news_manager->validateIdOfNewsPost() === false) {
$message = new Message('The post you are looking for does not exist.', 'index.php?section=news_management', 'Return to the news management');
require_once 'includes/header.php';
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if the file exists.

//Update a post.

if (isset($_POST['csrf_token'])) {
if (isset($_POST['update_news_post'])) {
if ($csrfToken->validateToken('update_news_post', $_POST['csrf_token'])) {
$news_post_title_form = '';
if (isset($_POST['news_post_title_form'])) {
$news_post_title_form = trim($_POST['news_post_title_form']);
}

$news_post_text_form = '';
if (isset($_POST['news_post_text_form'])) {
$news_post_text_form = trim($_POST['news_post_text_form']);
}

try {
$news_manager = new NewsManager($db);
$news_manager->setNewsPostTitle($news_post_title_form);
$news_manager->setNewsPostText($news_post_text_form);
$news_manager->setNewsPostId($news_post_id_get);
$result = $news_manager->updateNewsPost();
if ($result === true) {
$message = new Message('The news post was updated successfully.', 'index.php?section=news_management', 'Return');
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
$message = new Message('The session has expired for security reasons.', 'index.php?section=edit_file&id='. sanitize($news_post_id_get), 'Return to the news edit');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}
}
}

//Update a post.

//Output of the post.

$news_manager = new NewsManager($db);
$news_manager->setNewsPostId($news_post_id_get);
$news_post = $news_manager->getNewsPost();
include 'templates/edit_news_template.php';

//Output of the post.


?>
