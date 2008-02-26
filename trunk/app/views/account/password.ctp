<?php
/*
// TODO: disp errormsg
Rails:
<%= error_messages_for :member, :header_message => nil, :message => nil %>
Output:
<div id="errorExplanation" class="errorExplanation">
<ul>
<li>Password confirmation can't be blank</li>
<li>Password can't be blank</li>
<li>Password is too short (minimum is 4 characters)</li>
</ul>
</div>
*/
?>
<div id="content">
	<h2>Account</h2>
	<?php echo $this->renderElement('navi')?>
	<div class="account_form">
	<h4>Change password</h4>
	<p>Your password must be at least 5 charcters in length, and shoud not easily be guessed by other people.</p>
	<form method="post" action="/account/password">
		<?php // TODO: use authenticity_token ?>
		<input type="hidden" id="ApiKey" name="ApiKey" value="<?php eh(session_id())?>" />
		<dl>
			<dt><label for="password">Current Password</label></dt>
			<dd><input id="password" type="password" name="password" /><dd>
			<dt><label for="new_password">New Password</label></dt>
			<dd><input id="new_password" type="password" name="new_password" /><dd>
			<dt><label for="new_password_confirmation">Verify new Password</label></dt>
			<dd><input id="new_password_confirmation" type="password" name="new_password_confirmation" /><dd>
		</dl>
		<input type="submit" class="submit_button" value="OK" name="commit" />
	</form>
	</div>
	<div class="clear"></div>
</div>

