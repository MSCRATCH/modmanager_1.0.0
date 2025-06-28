<div class="message">
<p> <?php echo $e->getMessage();?></p>
<a href="index.php?section=item&id=<?php echo sanitize($file_id_get);?>"><button class="message_button">Return to the accessed file</button></a>
</div>
