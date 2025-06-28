<?php  $token3 = $csrfToken->generateToken('remove_news_confirm'); ?>
<div class="message">
<p>Are you sure you want to remove the news post with the ID <?php echo sanitize($news_id_remove_news_form);?>?</p>
<form method="post">
<input type="hidden" name="news_id_remove_news_confirm_form" value="<?php echo sanitize($news_id_remove_news_form);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token3;?>">
<button class="message_button" type="submit" name="remove_news_confirm">Confirm</button>
</form>
<a href="index.php?section=news_management"><button class="message_button">Cancel</button></a>
</div>
