<?php  $token1 = $csrfToken->generateToken('remove_file'); ?>
<?php if ($files !== false) { ?>
<div class="table_wrapper">
<div class="table_container">
<?php $i = 1; ?>
<?php foreach ($files as $file) { ?>
<div class="table_row">
<div class="table_cell"><?php echo sanitize($i);?>.</div>
<div class="table_cell"><a class="a_sm" href="index.php?section=item&id=<?php echo sanitize($file['file_id']);?>" target="_blank"><?php echo sanitize($file['file_name']);?> (<?php echo sanitize($file['file_id']);?>)</a></div>
<div class="table_cell"><?php echo sanitize($file['file_author']);?></div>
<div class="table_cell"><?php echo sanitize($file['file_uploaded']);?></div>
<div class="table_cell">
<a href="index.php?section=edit_file&id=<?php echo sanitize($file['file_id']);?>"><button class="button_4"><i class="fa-solid fa-pen-to-square"></i></button></a>
</div>
<div class="table_cell">
<form method="post">
<input type="hidden" name="file_id_remove_file_form" value="<?php echo sanitize($file['file_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="button_4" type="submit" name="remove_file"><i class="fa-solid fa-xmark"></i></button>
</form>
</div>
</div>
<?php $i++; ?>
<?php } ?>

</div>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=file_management'); ?>
</div>
</div>
<?php } else { ?>
<div class="message">
<p>There are no files.</p>
</div>
<?php } ?>
