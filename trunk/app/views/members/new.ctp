<div id="content">
<h2>Create new account</h2>
<?php if ($form->hasError()): ?>
<div id="errorExplanation" class="errorExplanation">
	<p>There were problems with the following fields:</p>
	<ul>
	<?php $form->errorMsg('Member.username', 'minLength', 'Username is too short (minimum is %s characters)')?>
	<?php $form->errorMsg('Member.username', 'maxLength', 'Username is too long (maximum is %s characters)')?>
	<?php $form->errorMsg('Member.username', 'unique', 'Username has already been taken')?>
	<?php $form->errorMsg('Member.password', 'minLength', 'Password is too short (minimum is %s characters)')?>
	<?php $form->errorMsg('Member.password', 'maxLength', 'Password is too long (maximum is %s characters)')?>
	<?php $form->errorMsg('Member.password', 'confirm', 'Password doesn\'t match confirmation')?>
	</ul>
</div>
<?php endif; ?>
<form method="post" action="/signup">
	<dl>
		<dt><label for="member_username">Username</label></dt>
		<dd><input id="username" type="text" size="30" name="username" /></dd>
		<dt><label for="member_password">Password</label></dt>
		<dd><input id="password" name="password" size="30" type="password"></dd>
		<dt><label for="member_password_confirmation">Confirm Password</label></dt>
		<dd><input id="password_confirmation" name="password_confirmation" size="30" type="password"></dd>
	</dl>
	<div class="submit"><input type="submit" value="Sign Up" name="commit" /></div>
<div class="section"><a href="/login">Back to Sign In</a></div>
</div>

