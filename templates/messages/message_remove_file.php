<?php  $token2 = $csrfToken->generateToken('remove_file_confirm'); ?>
<div class="message">
<p>Are you sure you want to remove the file with the ID <?php echo sanitize($file_id_remove_file_form);?>?</p>
<form method="post">
<input type="hidden" name="file_id_remove_file_confirm_form" value="<?php echo sanitize($file_id_remove_file_form);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token2;?>">
<button class="message_button" type="submit" name="remove_file_confirm">Confirm</button>
</form>
<a href="index.php?section=file_management"><button class="message_button">Cancel</button></a>
</div>
