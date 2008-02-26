<?php
$GLOBALS['CURRENT_ACTION'] = $this->action;

function selected($name)
{
    echo $name == $GLOBALS['CURRENT_ACTION'] ? 'class="selected"' : '';
}
?>
<ul class="account_navi">
	<li><a href="/account/password" <?php selected('password')?>>Password</a></li>
	<li><a href="/account/backup" <?php selected('backup')?>>Backup data</a></li>
	<li><a href="/account/share" <?php selected('share')?>>Share</a></li>
</ul>
