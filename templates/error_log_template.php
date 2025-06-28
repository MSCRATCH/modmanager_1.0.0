<?php if ($errors !== false) { ?>
<div class="wrapper_xxxl_nbg">
<?php foreach ($errors as $error) { ?>
<div class="content_container_mb">
<ul>
<li class="list_1">Error code: <?php echo sanitize($error['errno']);?></li>
<li class="list_1"><?php echo sanitize($error['errstr']);?></li>
<li class="list_1">Error in file <?php echo sanitize($error['errfile']);?></li>
<li class="list_1">Error in line <?php echo sanitize($error['errline']);?></li>
<li class="list_1"><?php echo sanitize($error['error_created_at']);?></li>
</ul>
</div>
<?php } ?>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=error_log'); ?>
</div>
</div>
<?php } else { ?>
<div class="message">
<p><?php echo sanitize(name); ?> <?php echo sanitize(version); ?> is currently running without errors.</p>
</div>
<?php } ?>
