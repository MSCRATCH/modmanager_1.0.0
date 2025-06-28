<?php  $token1 = $csrfToken->generateToken('submit_file'); ?>
<div class="file_wrapper">
<form class="form_column" method="post" enctype="multipart/form-data">
<div class="file_row">
<div class="file_column_1">
<?php if ($error_container->hasErrors()) { ?>
<ul>
<?php foreach ($error_container->getErrors() as $error) { ?>
<li class="list_1"><?php echo sanitize($error);?></li>
<?php } ?>
</ul>
<?php } ?>
<label for="file_name_form">Name</label><br>
<input class="form_text_1" type="text" name="file_name_form" id="file_name_form">
<label for="file_author_form">Author</label><br>
<input class="form_text_1" type="text" name="file_author_form" id="file_author_form">
<label for="file_description_form">Description</label><br>
<textarea class="form_textarea_2" name="file_description_form" id="file_description_form"></textarea>
<select class="select_2" name="enable_readme_form" id="enable_readme_form">
<option value="1">enable readme</option>
<option value="2">deactivate readme</option>
</select>
<label for="readme_file_form">Readme</label><br>
<textarea class="form_textarea_2" name="readme_file_form" id="readme_file_form"></textarea>
<?php if ($categories !== false) { ?>
<select class="select_2" name="category_id_form" id="category_id_form">
<?php foreach ($categories as $category) { ?>
<option value="<?php echo sanitize($category['category_id']);?>"><?php echo sanitize($category['category_name']);?></option>
<?php } ?>
</select>
<?php } ?>
<select class="select_2" name="file_type_form" id="file_type_form">
<option value="sp_map">singleplayer map</option>
<option value="mp_map">multiplayer map</option>
<option value="addon">addon</option>
<option value="modifiaction">modifiaction</option>
<option value="file">file</option>
</select>
</div>
<div class="file_column_2">
<label for="file">File</label><br>
<input type="file" name="file" id="file" size="90" maxlength="255">
<label for="image">Image</label><br>
<input type="file" name="image" id="image" size="90" maxlength="255">
<select class="select_2" name="enable_screenshots_form" id="enable_screenshots_form">
<option value="1">enable screenshots</option>
<option value="2">deactivate screenshots</option>
</select>
<label for="screenshots">Screenshots</label><br>
<input type="file" name="screenshots[]" multiple id="screenshots">
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="file_button" type="submit" name="submit_file">Submit</button>
</div>
</div>
</form>
</div>
