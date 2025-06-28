<div class="wrapper_xxl_nbg">
<?php foreach ($result as $row) { ?>
<div class="content_container_mb">
<ul>
<li class="list_1"><?php echo sanitize($row['news_post_title']);?></li>
<li class="list_1"><a class="a_sm" href="index.php?section=profile&id=<?php echo sanitize($row['user_id']);?>"><?php echo sanitize_ucfirst($row['username']);?> at <?php echo sanitize($row['news_post_created']);?></a></li>
<li class="list_2"><?php echo sanitize($row['news_post_text']);?></li>
</ul>
</div>
<?php } ?>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=news'); ?>
</div>
</div>
