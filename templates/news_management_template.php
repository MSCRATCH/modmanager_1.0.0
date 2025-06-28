<?php  $token1 = $csrfToken->generateToken('submit_news_post'); ?>
<?php  $token2 = $csrfToken->generateToken('remove_news_post'); ?>
<div class="wrapper_xxxl_nbg">
<form action="" method="post">
<h2 class="headline_1">Title</h2>
<input class="form_text_1" type="text" name="news_post_title_form" id="news_post_title_form">
<h2 class="headline_1">Text</h2>
<textarea class="form_textarea_2" name="news_post_text_form" id="news_post_text_form"></textarea>
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="file_button" type="submit" name="submit_news_post">Submit news post</button>
</form>
</div>
<?php if ($news !== false) { ?>
<div class="table_wrapper">
<div class="table_container">
<?php $i = 1; ?>
<?php foreach ($news as $news_post) { ?>
<div class="table_row">
<div class="table_cell"><?php echo sanitize($i);?>.</div>
<div class="table_cell"><a class="a_sm" href="index.php?section=news" target="_blank"><?php echo sanitize($news_post['news_post_title']);?> (<?php echo sanitize($news_post['news_post_id']);?>)</a></div>
<div class="table_cell"><?php echo sanitize($news_post['news_post_created']);?></div>
<div class="table_cell"><?php echo sanitize($news_post['username']);?></div>
<div class="table_cell">
<a href="index.php?section=edit_news&id=<?php echo sanitize($news_post['news_post_id']);?>"><button class="button_4"><i class="fa-solid fa-pen-to-square"></i></button></a>
</div>
<div class="table_cell">
<form method="post">
<input type="hidden" name="news_id_remove_news_form" value="<?php echo sanitize($news_post['news_post_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token2;?>">
<button class="button_4" type="submit" name="remove_news_post"><i class="fa-solid fa-xmark"></i></button>
</form>
</div>
</div>
<?php $i++; ?>
<?php } ?>
</div>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=news_management'); ?>
</div>
</div>
<?php } ?>
