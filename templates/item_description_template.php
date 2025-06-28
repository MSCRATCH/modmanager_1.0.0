<div class="view_item_content">
<img src="images/<?php echo sanitize($file_description['file_title_image']);?>" alt="file_image" class="view_item_title_image">
<div class="view_item_description">
<ul>
<li><?php echo sanitize($file_description['file_name']);?></li>
<li><?php echo sanitize($file_description['file_author']);?></li>
<li><?php echo sanitize($file_description['file_uploaded']);?></li>
<li><?php echo sanitize($file_description['file_description']);?></li>
<?php if ($readme !== false) { ?>
<li class="list_3"><a href="index.php?section=readme&id=<?php echo sanitize($file_description['file_id']);?>"><button class="button_2">Show Readme</button></a></li>
<?php } ?>
<?php if ($file_description['file_type'] === 'sp_map' OR $file_description['file_type'] === 'addon') { ?>
<?php if ($game_log_count_for_file === 1) { ?>
<li class="list_3"><?php echo sanitize($game_log_count_for_file);?> User have played <?php echo sanitize($file_description['file_name']);?></li>
<?php } else { ?>
<li class="list_3"><?php echo sanitize($game_log_count_for_file);?> Users have played <?php echo sanitize($file_description['file_name']);?></li>
<?php } ?>
<?php } ?>
<?php if ($like_count_for_file === 1) { ?>
<li class="list_4"><?php echo sanitize($like_count_for_file);?> User likes <?php echo sanitize($file_description['file_name']);?></li>
<?php } else { ?>
<li class="list_4"><?php echo sanitize($like_count_for_file);?> Users like <?php echo sanitize($file_description['file_name']);?></li>
<?php } ?>
<li><a href="index.php?section=download&id=<?php echo sanitize($file_description['file_id']);?>"><button class="button_2">Download</button></a></li>
</ul>
<?php if (Auth::isLoggedIn() && ($file_description['file_type'] === 'sp_map' OR $file_description['file_type'] === 'addon')) { ?>
<?php if ($is_in_gameLog === true) { ?>
<?php  $token2 = $csrfToken->generateToken('remove_from_game_log'); ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token2;?>">
<button class="button_2" type="submit" name="remove_from_game_log">Remove from GameLog</button>
</form>
<?php } else { ?>
<?php  $token1 = $csrfToken->generateToken('add_to_game_log'); ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="button_2" type="submit" name="add_to_game_log">Add to GameLog</button>
</form>
<?php } ?>
<?php } ?>
<?php if (Auth::isLoggedIn()) { ?>
<?php if ($is_liked === true) { ?>
<?php  $token4 = $csrfToken->generateToken('remove_like'); ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token4;?>">
<button class="button_2" type="submit" name="remove_like">Remove Like</button>
</form>
<?php } else { ?>
<?php  $token3 = $csrfToken->generateToken('add_like'); ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token3;?>">
<button class="button_2" type="submit" name="add_like">Like</button>
</form>
<?php } ?>
<?php } ?>
</div>
</div>
