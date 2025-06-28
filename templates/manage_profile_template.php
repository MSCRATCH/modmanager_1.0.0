<?php  $token1 = $csrfToken->generateToken('update_user_profile_description'); ?>
<div class="wrapper_xxl_nbg">
<form method="post">
<textarea class="form_textarea_1" name="user_profile_description_form" id="user_profile_description_form"><?php echo sanitize($user_profile_data['user_profile_description']);?></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="button_3" type="submit" name="update_user_profile_description">Update</button>
</form>
</div>
