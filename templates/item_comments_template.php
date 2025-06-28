<?php if ($file_comments !== false) { ?>
<?php foreach ($file_comments as $file_comment) { ?>
<div class="content_container_mb">
<ul>
<li><a class="a_sm" href="index.php?section=profile&id=<?php echo sanitize($file_comment['user_id']);?>"><?php echo sanitize_ucfirst($file_comment['username']);?></a></li>
<li><?php echo sanitize($file_comment['file_comment_created']);?></li>
<li><?php echo sanitize($file_comment['file_comment']);?></li>
</ul>
<?php if (Auth::isAdministrator()) { ?>
<?php  $token5 = $csrfToken->generateToken('remove_comment'); ?>
<form method="post">
<input type="hidden" name="file_comment_id_remove_comment" value="<?php echo sanitize($file_comment['file_comment_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token5;?>">
<button class="button_4" type="submit" name="remove_comment"><i class="fa-solid fa-xmark"></i></button>
</form>
<?php } ?>
</div>
<?php } ?>
<?php } else { ?>
<div class="content_container_mb">
<p>No comments have been written yet.</p>
</div>
<?php } ?>
