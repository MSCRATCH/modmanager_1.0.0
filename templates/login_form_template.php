<div class="wrapper_sm_nbg">
<?php  $token1 = $csrfToken->generateToken('login'); ?>
<form method="post">
<label for="username_form">Username</label><br>
<input class="form_text_1" type="text" name="username_form" id="username_form">
<label for="user_password_form">Username</label><br>
<input class="form_password_1" type="password" name="user_password_form" id="user_password_form">
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="button_5" type="submit" name="login">Login</button>
</form>
</div>
