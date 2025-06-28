<?php  $token1 = $csrfToken->generateToken('update_user_level'); ?>
<?php  $token2 = $csrfToken->generateToken('remove_user'); ?>
<div class="table_wrapper">
<div class="table_container">
<?php $i = 1; ?>
<?php foreach ($users as $user) { ?>
<div class="table_row">
<div class="table_cell"><?php echo sanitize($i);?>.</div>
<div class="table_cell"><a class="a_sm" href="index.php?section=profile&id=<?php echo sanitize($user['user_id']);?>" target="_blank"><?php echo sanitize($user['username']);?> (<?php echo sanitize($user['user_id']);?>)</a></div>
<div class="table_cell"><?php echo sanitize($user['user_email']);?></div>
<div class="table_cell"><?php echo sanitize($user['user_level']);?></div>
<div class="table_cell"><?php echo sanitize($user['user_date']);?></div>
<div class="table_cell">
<?php if ($user['user_level'] !== 'administrator') { ?>
<form method="post">
<input type="hidden" name="user_id_remove_user_form" value="<?php echo sanitize($user['user_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token2;?>">
<button class="button_4" type="submit" name="remove_user"><i class="fa-solid fa-xmark"></i></button>
</form>
<?php } else { ?>
action not available.
<?php } ?>
</div>
<div class="table_cell">
<?php if ($user['user_level'] !== 'administrator') { ?>
<form class="form_row" method="post">
<select class="select" name="user_level_form" id="user_level">
<option value="<?php echo sanitize($user['user_level']);?>"><?php echo sanitize($user['user_level']);?></option>
<?php if ($user['user_level'] !== 'user') { ?>
<option value="user">user</option>
<?php } ?>
<?php if ($user['user_level'] !== 'not_activated') { ?>
<option value="not_activated">not activated</option>
<?php } ?>
</select>
<input type="hidden" name="user_id_user_level_form" value="<?php echo sanitize($user['user_id']);?>">
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="button_4" type="submit" name="update_user_level"><i class="fa-solid fa-pen-to-square"></i></button>
</form>
<?php } else { ?>
action not available.
<?php } ?>
</div>
</div>
<?php $i++; ?>
<?php } ?>

</div>
<div class="pagination">
<?php echo $pagination->renderPagination('index.php?section=user_management'); ?>
</div>
</div>
