<?php  $token1 = $csrfToken->generateToken('download_item'); ?>
<?php if ($result !== false) { ?>
<div class="message">
<p>Files are always checked carefully for their security.</p>
<p>Download <?php echo sanitize($result['file_name']);?></p>
<form method="post">
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">  
<button class="button_1" type="submit" name="download_item">Download <?php echo fileSizeFormatted($file_size);?></button>
</form>
</div>
<?php } ?>
