<div class="nav_list_wrapper">
<div class="content_container">
<ul>
<li class="list_1"><?php echo sanitize_strtoupper($user_profile_data['username']);?></li>
<li class="list_1"><?php echo sanitize_ucfirst($user_profile_data['username']);?> has <?php echo sanitize($user_game_log_stats);?> entries in his GameLog.</li>
</ul>
<?php if (! empty($user_profile_data['user_profile_description'])) { ?>
<?php echo sanitize($user_profile_data['user_profile_description']);?>
<?php } else { ?>
</p><?php echo sanitize_ucfirst($user_profile_data['username']);?> has not yet added a profile description.</p>
<?php } ?>
</div>
<div class="nav_list_container">
<?php if ($game_log_result !== false) { ?>
<a href="index.php?section=user_game_log&id=<?php echo sanitize($user_id_get);?>" class="nav_list_item">
<div class="nav_list_content">
<p><span>Show entire GameLog</span></p>
</div>
</a>
<?php foreach ($game_log_result as $row) { ?>
<a href="index.php?section=item&id=<?php echo sanitize($row['file_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<p><?php echo sanitize_ucfirst($user_profile_data['username']);?> has played through <span><?php echo sanitize($row['file_name']);?></span></p>
</div>
</a>
<?php } ?>
<?php } else { ?>
<div class="content_container_mb"></p><?php echo sanitize_ucfirst($user_profile_data['username']);?> has not added anything to his game log yet.</p></div>
<?php } ?>
</div>
<div class="nav_list_container">
<?php if ($user_comments !== false) { ?>
<?php foreach ($user_comments as $user_comment) { ?>
<a href="index.php?section=item&id=<?php echo sanitize($user_comment['file_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<p><?php echo sanitize_ucfirst($user_profile_data['username']);?> wrote a comment on <span><?php echo sanitize($user_comment['file_name']);?></span></p>
</div>
<p><?php echo sanitize($user_comment['file_comment_created']);?></p>
<p><?php echo sanitize($user_comment['file_comment']);?></p>
</a>
<?php } ?>
<?php } else { ?>
<div class="content_container_mb"></p><?php echo sanitize_ucfirst($user_profile_data['username']);?> has not yet written a comment.</p></div>
<?php } ?>
</div>
<div class="nav_list_container">
<?php if ($user_likes !== false) { ?>
<?php foreach ($user_likes as $user_like) { ?>
<a href="index.php?section=item&id=<?php echo sanitize($user_like['file_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<p><?php echo sanitize_ucfirst($user_profile_data['username']);?> liked <span><?php echo sanitize($user_like['file_name']);?></span></p>
<p><?php echo sanitize($user_like['file_like_created']);?></p>
</div>
</a>
<?php } ?>
<?php } else { ?>
<div class="content_container_mb"></p><?php echo sanitize_ucfirst($user_profile_data['username']);?> has not liked any file yet.</p></div>
<?php } ?>
</div>
</div>
