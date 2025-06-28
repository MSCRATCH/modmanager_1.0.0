<?php if (Auth::isLoggedIn()) { ?>
<?php  $token6 = $csrfToken->generateToken('create_comment'); ?>
<form method="post">
<textarea class="form_textarea_1" name="file_comment_form" id="file_comment_form"></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token6;?>">
<button class="button_3" type="submit" name="create_comment">Comment</button>
</form>
<?php } else { ?>
<div class="content_container_mb">
<p>Log in to post a comment.</p>
</div>
<?php } ?>
