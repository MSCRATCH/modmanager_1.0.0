<?php if ($result !== false) { ?>
<div class="gallery_wrapper">
<div class="gallery">
<?php foreach ($result as $row) { ?>
<div class="gallery_item">
<a href="index.php?section=item&id=<?php echo sanitize($row['file_id']);?>"><img src="images/<?php echo sanitize($row['file_title_image']);?>" alt="file_image" class="responsive_gallery_image"></a>
<div class="gallery_description">
<ul>
<li class="list_1"><?php echo sanitize($row['file_name']);?></li>
<li class="list_1"><?php echo sanitize($row['file_author']);?></li>
<li class="list_1"><?php echo sanitize($row['file_description']);?></li>
<li class="list_1"><?php echo sanitize($row['file_uploaded']);?></li>
</ul>
</div>
</div>
<?php } ?>
</div>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=items&id='. $category_id_get); ?>
</div>
</div>
<?php } ?>
