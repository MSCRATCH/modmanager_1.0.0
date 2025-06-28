<?php

//profile.php [Output of the respective profile.]

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
$message = new Message('The user profile does not exist.', 'index.php?section=categories', 'Return to the homepage');
echo $message->renderMessage();
require_once 'includes/footer.php';
exit();
}

//Check if a user exists.

//Output of the respective profile.

$profile_manager = new ProfileManager($db);
$profile_manager->setUserId($user_id_get);
$user_profile_data = $profile_manager->getUserProfile();
$comment_manager = new CommentManager($db);
$comment_manager->setUserId($user_id_get);
$user_comments = $comment_manager->getUserComments();
$game_log = new GameLog($db);
$game_log->setUserId($user_id_get);
$game_log_result = $game_log->getUserGameLogPreview();
$user_game_log_stats = $game_log->getUserGameLogStats();
$like_manager = new LikeManager($db);
$like_manager->setUserId($user_id_get);
$user_likes = $like_manager->getUserLikesPreview();
include 'templates/profile_template.php';

//Output of the respective profile.

?>
