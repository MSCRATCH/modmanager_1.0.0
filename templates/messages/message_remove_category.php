<?php  $token4 = $csrfToken->generateToken('remove_category_confirm'); ?>
<div class="message">
<p>Are you sure you want to remove the category with the ID <?php echo sanitize($category_id_remove_category_form);?> ?</p>
<p>Note that this will also remove all files assigned to the category. If you don't want this to happen, move the files to other existing categories first. Keep in mind that all files, cover images, and screenshots associated with the category will also be removed.</p>
<form method="post">
<input type="hidden" name="category_id_remove_category_confirm_form" value="<?php echo sanitize($category_id_remove_category_form);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token4;?>">
<button class="message_button" type="submit" name="remove_category_confirm">Confirm</button>
</form>
<a href="index.php?section=category_management"><button class="message_button">Cancel</button></a>
</div>
