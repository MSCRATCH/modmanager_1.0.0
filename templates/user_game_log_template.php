<div class="nav_list_wrapper">
<div class="nav_list_container">
<a href="index.php?section=profile&id=<?php echo sanitize($user_id_get);?>" class="nav_list_item">
<div class="nav_list_content">
<p><span>View the user profile</span></p>
</div>
</a>
<?php foreach ($result as $row) { ?>
<a href="index.php?section=item&id=<?php echo sanitize($row['file_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<p><?php echo sanitize_ucfirst($row['username']);?> has played through <span><?php echo sanitize($row['file_name']);?></span></p>
<p><?php echo sanitize($row['game_log_created']);?></p>
</div>
</a>
<?php } ?>
</div>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=user_game_log&id='. $user_id_get); ?>
</div>
</div>
