<?php  $token1 = $csrfToken->generateToken('submit_description'); ?>
<?php  $token2 = $csrfToken->generateToken('update_file'); ?>
<?php  $token3 = $csrfToken->generateToken('update_image'); ?>
<?php  $token4 = $csrfToken->generateToken('remove_screenshot'); ?>
<?php  $token5 = $csrfToken->generateToken('update_screenshots'); ?>
<?php  $token6 = $csrfToken->generateToken('create_readme'); ?>
<?php  $token7 = $csrfToken->generateToken('update_readme'); ?>
<?php  $token8 = $csrfToken->generateToken('remove_readme'); ?>

<div class="file_wrapper">
<div class="file_row">
<div class="file_column_1">
<?php if ($error_container->hasErrors()) { ?>
<ul>
<?php foreach ($error_container->getErrors() as $error) { ?>
<li class="list_1"><?php echo sanitize($error);?></li>
<?php } ?>
</ul>
<?php } ?>
<form class="form_column" method="post">
<label for="file_name_form">File name</label><br>
<input class="form_text_1" type="text" name="file_name_form" id="file_name_form" value="<?php echo sanitize($file['file_name']);?>">
<label for="file_author_form">File author</label><br>
<input class="form_text_1" type="text" name="file_author_form" id="file_author_form" value="<?php echo sanitize($file['file_author']);?>">
<label for="file_download_form">File path</label><br>
<input class="form_text_1" type="text" name="file_download_form" id="file_download_form" value="<?php echo sanitize($file['file_download']);?>">
<label for="file_download_form">Image path</label><br>
<input class="form_text_1" type="text" name="file_title_image_form" id="file_title_image_form" value="<?php echo sanitize($file['file_title_image']);?>">
<label for="file_description_form">File description</label><br>
<textarea class="form_textarea_2" name="file_description_form" id="file_description_form"><?php echo sanitize($file['file_description']);?></textarea>
<label for="file_type_form">Select a file type</label><br>
<select class="select_2" name="file_type_form" id="file_type_form">
<option value="sp_map">singleplayer map</option>
<option value="mp_map">multiplayer map</option>
<option value="addon">addon</option>
<option value="modifiaction">modifiaction</option>
<option value="file">file</option>
</select>
<label for="category_id_form">Select a category</label><br>
<select class="select_2" name="category_id_form" id="category_id_form">
<?php foreach ($categories as $category) { ?>
<option value="<?php echo sanitize($category['category_id']);?>"><?php echo sanitize($category['category_name']);?></option>
<?php } ?>
</select>
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="file_button" type="submit" name="submit_description">Submit description</button>
</form>
</div>
<div class="file_column_2">
<form class="form_column" method="post">
<?php if ($file_images !== false) { ?>
<ul>
<?php foreach ($file_images as $file_image) { ?>
<li class="list_1"><a class="a_sm" href="images/<?php echo sanitize($file_image['file_image']);?>"><?php echo sanitize($file_image['file_image']);?></a></li>
<input type="hidden" name="csrf_token" value="<?php echo $token4;?>">
<li class="list_1"><button class="file_button" type="submit" name="remove_screenshot" value="<?php echo sanitize($file_image['file_image_id']);?>">Remove</button></li>
<?php } ?>
</ul>
<?php } ?>
</form>

<form class="form_column" method="post" enctype="multipart/form-data">
<label for="file">File</label><br>
<input type="file" name="file" id="file" size="90" maxlength="255">
<input type="hidden" name="csrf_token" value="<?php echo $token2;?>">
<button class="file_button" type="submit" name="update_file">Update file</button>
</form>

<form class="form_column" method="post" enctype="multipart/form-data">
<label for="image">Image</label><br>
<input type="file" name="image" id="image" size="90" maxlength="255">
<input type="hidden" name="csrf_token" value="<?php echo $token3;?>">
<button class="file_button" type="submit" name="update_image">Update image</button>
</form>

<form class="form_column" method="post" enctype="multipart/form-data">
<label for="screenshots">Screenshots</label><br>
<input type="file" name="screenshots[]" multiple id="screenshots">
<input type="hidden" name="csrf_token" value="<?php echo $token5;?>">
<button class="file_button" type="submit" name="update_screenshots">Update Screenshots</button>
</form>
<a href="index.php?section=file_management"><button class="file_button">Return to file management</button></a>
</div>
</div>
<?php if (isset($readme) && $readme !== false) { ?>
<form class="form_column_file" method="post">
  <input type="hidden" name="csrf_token" value="<?php echo $token8;?>">
<button class="file_button" type="submit" name="remove_readme">Remove readme</button>
</form>
<form class="form_column_file" method="post">
<label for="file_readme_content_form">Readme</label><br>
<textarea class="form_textarea_3" name="file_readme_content_form" id="file_readme_content_form"><?php echo sanitize($readme['file_readme_content']);?></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token7;?>">
<button class="file_button" type="submit" name="update_readme">Update readme</button>
</form>
<?php } else { ?>
<form class="form_column_file" method="post">
<label for="file_readme_content_form">Readme</label><br>
<textarea class="form_textarea_3" name="file_readme_content_form" id="file_readme_content_form"></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token6;?>">
<button class="file_button" type="submit" name="create_readme">Create readme</button>
</form>
<?php } ?>
</div>
