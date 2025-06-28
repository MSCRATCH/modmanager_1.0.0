<?php if ($file_images !== false) { ?>
<div class="slider">
<?php foreach ($file_images as $index => $file_image) { ?>
<img src="images/<?php echo sanitize($file_image['file_image']);?>" alt="file_image" class="<?php echo $index === 0 ? 'active' : '';?>">
<?php } ?>
</div>
<?php } ?>
