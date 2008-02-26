<div id="content">
	<h2>Account</h2>
	<?php echo $this->renderElement('navi')?>
	<div class="account_form">
	<h4>Account setting</h4>
	<form>
	<dl>
		<dt><label>User ID</label></dt>
		<dd><?php eh($member['Member']['username'])?></dd>
		<dt><label>Password</label></dt>
		<dd>******** <a href="./password">Edit</a></dd>
	</dl>
	</form>
	</div>
</div>
