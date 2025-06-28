<div class="wrapper_sm_nbg">
<?php  $token1 = $csrfToken->generateToken('register'); ?>
<?php if ($error_container->hasErrors()) { ?>
<ul>
<?php foreach ($error_container->getErrors() as $error) { ?>
<li class="list_1"><?php echo sanitize($error);?></li>
<?php } ?>
</ul>
<?php } ?>
<form method="post">
<label for="username_form">Username</label><br>
<input class="form_text_1" type="text" name="username_form" id="username_form">
<label for="password_form">Password</label><br>
<input class="form_password_1" type="password" name="password_form" id="password_form">
<label for="user_password_confirm_form">Password comparison</label><br>
<input class="form_password_1" type="password" name="user_password_confirm_form" id="user_password_confirm_form">
<label for="user_email_form">E-mail address</label><br>
<input class="form_text_1" type="text" name="user_email_form" id="user_email_form">
<label for="security_question_answer_form">Security question</label><br>
<p>What is something nobody wants to be, but everyone will be?</p>
<input class="form_text_1" type="text" name="security_question_answer_form" id="security_question_answer_form">
<p>By registering you agree to the terms of use.</p>
<input type="hidden" name="csrf_token" value="<?php echo $token1;?>">
<button class="button_5" type="submit" name="register">Register</button>
</form>
</div>
