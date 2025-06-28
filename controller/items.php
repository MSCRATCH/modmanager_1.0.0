<?php

//items.php [Output of the file preview.]

require_once 'includes/header.php';

//ID of the category.

$category_id_get = '';
if (isset($_GET['id'])) {
$category_id_get = (INT) $_GET['id'];
}

//ID of the category.

//Check if the category exists.

$category_manager = new CategoryManager($db);
$category_manager->setCategoryId($category_id_get);
if ($category_manager->validateIdOfCategory() === false) {
$message = new Message('The category you are looking for does not exist.', 'index.php?section=categories', 'Return to the homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if the category exists.

//Specify how many records should be displayed on each page.

$entries_per_page = 25;

//Specify how many records should be displayed on each page.

$file_manager = new FileManager($db);
$file_manager->setCategoryId($category_id_get);
$total_records = $file_manager->getNumberOfFiles();

//Pagination.

$current_page = isset($_GET['page']) ? (INT) $_GET['page'] : 1;
$pagination = new Pagination($entries_per_page, $current_page, $total_records);
$pagination->isValidPageNumber();
$offset = $pagination->getOffset();

//Pagination.

$file_manager->setEntriesPerPage($entries_per_page);
$file_manager->setOffset($offset);
$result = $file_manager->getFileDescriptionPreview();
if ($result === false) {
$message = new Message('This category contains no files.');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
include 'templates/items_template.php';
}


?>
