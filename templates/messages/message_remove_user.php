<?php  $token3 = $csrfToken->generateToken('remove_user_confirm'); ?>
<div class="message">
<p>Are you sure you want to remove the user with the ID <?php echo sanitize($user_id_remove_user_form);?>?</p>
<form method="post">
<input type="hidden" name="user_id_remove_user_confirm_form" value="<?php echo sanitize($user_id_remove_user_form);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token3;?>">
<button class="message_button" type="submit" name="remove_user_confirm">Confirm</button>
</form>
<a href="index.php?section=user_management"><button class="message_button">Cancel</button></a>
</div>
