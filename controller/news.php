<?php

//news.php [output posts.]

require_once 'includes/header.php';

//Specify how many records should be displayed on each page.

$entries_per_page = 5;

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
$result = $news_manager->getNewsPosts();
if ($result === false) {
$message = new Message('There are currently no news posts.');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
include 'templates/news_template.php';
}

?>
