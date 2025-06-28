<?php  $token1 = $csrfToken->generateToken('update_news_post'); ?>
<div class="wrapper_xxxl_nbg">
<form method="post">
<label for="news_post_title_form">Title</label><br>
<input class="form_text_1" type="text" name="news_post_title_form" id="news_post_title_form" value="<?php echo sanitize($news_post['news_post_title']);?>">
<label for="news_post_text_form">Text</label><br>
<textarea class="form_textarea_2" name="news_post_text_form" id="news_post_text_form"><?php echo sanitize($news_post['news_post_text']);?></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="file_button" type="submit" name="update_news_post">Update news post</button>
</form>
<a href="index.php?section=news_management"><button class="file_button">Return to news management</button></a>
</div>
