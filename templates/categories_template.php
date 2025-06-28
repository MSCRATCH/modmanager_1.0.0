<div class="nav_list_wrapper">
<div class="nav_list_container">
<?php foreach ($categories as $category) { ?>
<a href="index.php?section=items&id=<?php echo sanitize($category['category_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<h2><?php echo sanitize_ucfirst($category['category_name']);?></h2>
</div>
<p><?php echo sanitize($category['category_description']);?></p>
<p>The category contains <?php echo sanitize($category['file_count']);?> files.</p>
</a>
<?php } ?>
</div>
<div class="nav_list_container">
<?php if ($top_players !== false) { ?>
<?php $i = 1; ?>
<?php foreach ($top_players as $top_player) { ?>
<a href="index.php?section=profile&id=<?php echo sanitize($top_player['user_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<p><span><?php echo sanitize($i);?>. <?php echo sanitize_ucfirst($top_player['username']);?></span> played <?php echo sanitize($top_player['top_player_count']);?> maps or addons</p>
</div>
</a>
<?php $i++; ?>
<?php } ?>
<?php } else { ?>
<div class="content_container_mb">
<p>So far, no player has added anything to their game log.</p>
</div>
<?php } ?>
</div>
<div class="nav_list_container">
<?php if ($most_played_files !== false) { ?>
<?php $i = 1; ?>
<?php foreach ($most_played_files as $most_played_file) { ?>
<a href="index.php?section=item&id=<?php echo sanitize($most_played_file['file_id']);?>" class="nav_list_item">
<div class="nav_list_content">
<p><span><?php echo sanitize($i);?>. <?php echo sanitize($most_played_file['file_name']);?></span> was played by <?php echo sanitize($most_played_file['most_played_file_count']);?> users</p>
</div>
</a>
<?php $i++; ?>
<?php } ?>
<?php } else { ?>
<div class="content_container_mb">
<p>Nothing has been played yet.</p>
</div>
<?php } ?>
</div>
</div>
