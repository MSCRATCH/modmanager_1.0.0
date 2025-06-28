<?php

//error_log.php [Output of errors.]

if (! Auth::isAdministrator()) {
header('Location: index.php?section=login');
exit();
}

require_once 'includes/header.php';

//Specify how many records should be displayed on each page.

$entries_per_page = 50;

//Specify how many records should be displayed on each page.

try {
$error_handler = new ErrorHandler($db);
$total_records = $error_handler->getNumberOfErrors();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->isValidPageNumber();
$offset = $pagination->getOffset();

//Pagination.

$error_handler->setEntriesPerPage($entries_per_page);
$error_handler->setOffset($offset);
$errors = $error_handler->getErrors();
include 'templates/error_log_template.php';
} catch (Exception $e) {
include 'templates/messages/message.php';
}



?>
