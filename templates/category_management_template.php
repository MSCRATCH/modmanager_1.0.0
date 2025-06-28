<?php  $token1 = $csrfToken->generateToken('submit_category'); ?>
<?php  $token2 = $csrfToken->generateToken('update_category'); ?>
<?php  $token3 = $csrfToken->generateToken('remove_category'); ?>
<div class="wrapper_xxxl_nbg">
<form method="post">
<label for="category_name_form">Category title</label><br>
<input class="form_text_1" type="text" name="category_name_form" id="category_name_form">
<label for="category_description_form">Category description</label><br>
<textarea class="form_textarea_2" name="category_description_form" id="category_description_form"></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="file_button" type="submit" name="submit_category">Submit category</button>
</form>
<?php if ($categories !== false) { ?>
<?php foreach ($categories as $category) { ?>
<form method="post">
<label for="category_name_update_form">Category title</label><br>
<input class="form_text_1" type="text" name="category_name_update_form" id="category_name_update_form" value="<?php echo sanitize_ucfirst($category['category_name']);?>">
<label for="category_description_update_form">Category description</label><br>
<textarea class="form_textarea_2" name="category_description_update_form" id="category_description_update_form"><?php echo sanitize($category['category_description']);?></textarea>
<input type="hidden" name="category_id_remove_update_form" value="<?php echo sanitize($category['category_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token2;?>">
<button class="file_button" type="submit" name="update_category"><i class="fa-solid fa-pen-to-square"></i></button>
</form>
<form method="post">
<input type="hidden" name="category_id_remove_category_form" value="<?php echo sanitize($category['category_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token3;?>">
<button class="file_button" type="submit" name="remove_category"><i class="fa-solid fa-xmark"></i></button>
</form>
<?php } ?>
<?php } ?>
</div>
