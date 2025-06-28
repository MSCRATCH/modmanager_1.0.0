<div class="wrapper_xxl_nbg">
<p><a class="a_sm" href="index.php?section=item&id=<?php echo sanitize($readme['file_id']);?>">Readme from <?php echo sanitize_ucfirst($readme['file_name']);?></a></p>
<pre>
<code>
<?php echo sanitize($readme['file_readme_content']);?>
</pre>
</code>
</div>
