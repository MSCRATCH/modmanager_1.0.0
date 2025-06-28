<div class="message">
<p> <?php echo $e->getMessage();?></p>
<a href="index.php?section=edit_file&id=<?php echo sanitize($file_id_get);?>"><button class="message_button">Return to the edit file</button></a>
</div>
