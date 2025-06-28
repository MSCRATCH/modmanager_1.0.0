<?php

//categories.php [Output of categories.]

require_once 'includes/header.php';

$category_manager = new CategoryManager($db);
$categories = $category_manager->getCategories();
if ($categories === false) {
$message = new Message('Currently no category has been created.');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
} else {
$game_log = new GameLog($db);
$top_players = $game_log->getTopPlayers();
$most_played_files = $game_log->getMostPlayedFiles();
include 'templates/categories_template.php';
}

?>
