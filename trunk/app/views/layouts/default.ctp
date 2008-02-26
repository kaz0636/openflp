<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Fastladder <?php eh($this->pageTitle ? $this->pageTitle : ($this->action == 'index' ? '' : $this->action))?></title>
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <link href="/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body class="<?php eh(strtolower($this->name))?>">
<script type="text/javascript">var ApiKey = "<?php eh(session_id())?>";</script>
<?php $basics->loadJS(array('compat','common','event','template','api','reader_subscribe','round_corner'))?>
<div id="container">
<div class="navi">
<h1 class="logo"><a href="/">Fastladder</a></h1>
<?php if (!empty($member)): ?>
<ul>
	<li>Welcome <a href="<?php eh("/user/{$member['Member']['username']}")?>"><?php eh($member['Member']['username'])?></a></li>
	<li><a href="/reader/">My Feeds</a></li>
	<li><a href="/account/">Account</a></li>
	<li><a href="/logout?sv=<?php eh(session_id())?>">Sign Out</a></li>
</ul>
<?php endif; ?>
</div>
<?php if ($Flash->notice()): ?>
<div class="notice" style="text-align:center;background-color:#ff9;padding:0.5em">
    <p style="color: green"><?php eh($Flash->notice())?></p>
</div>
<?php endif; ?>
<?php echo $content_for_layout?>
</div>
</body>
</html>
