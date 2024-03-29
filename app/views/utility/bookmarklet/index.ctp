<div id="content" class="bookmarklet">
	<h2>Browser Buttons</h2>
	<p>You can subscribe to a feed from anywhere with the <em>browser buttons</em>.</p>
	<div class="sub-content">
	<script type="text/javascript">
	if(navigator.userAgent.indexOf("MSIE") != -1){
		document.write(
			"<p>To install 'Browser Button', right click on this button and select the 'Add to Favorites' link. You may see a warning dialog, click 'OK' to continue.</p>"
		);
	} else {
		document.write(
			"<p>Drag these buttons to Your 'Bookmarks toolbar'</p>"
		);
	}
	</script>
	<div id="bmicon">
		<a href="javascript:location.href='<?php eh(Router::url('/',true))?>subscribe/'+location.href" title="Subscribe with OpenFLP"><img src="/img/parts/bm_01.gif" width="172" height="24" alt="Subscribe with OpenFLP" title="Subscribe with OpenFLP"></a>
		<a href="<?php eh(Router::url('/',true))?>reader/" title="OpenFLP"><img src="/img/parts/bm_02.gif" width="90" height="24" alt="OpenFLP" title="OpenFLP"></a>
	</div>
	<script type="text/javascript">
	new function(){
		if (navigator.userAgent.indexOf("MSIE") != -1){
			var swf_path = '/swf/tutorial_ie.swf';
			var height = 250;
		} else {
			var swf_path = '/swf/tutorial_ff.swf';
			var height = 200;
		}
		document.write([
			 '<div id="bmflash">'
			,'<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"'
			,' codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"'
			,' width="520" height="', height ,'" id="tutorial_ie" align="middle">'
			,'<param name="allowScriptAccess" value="sameDomain" />'
			,'<param name="movie" value="/swf/tutorial_ie.swf" />'
			,'<param name="quality" value="high" />'
			,'<param name="bgcolor" value="#ffffff" />'
			,'<embed src="', swf_path, '" quality="high" bgcolor="#ffffff" width="520" height="', height, '"'
			,' name="tutorial_ie" align="middle" allowScriptAccess="sameDomain"'
			,' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />'
			,'</object></div>'
		].join(""));
	};
	</script>
	</div>
	<h3>For Firefox2 users</h3>
	<div class="sub-content">
	<p>
		Firefox2 users can add OpenFLP to the list of feed readers.<br />
		Click feed icon and subscribe to the site as you browse.<br />
		<img src="/img/parts/bm_ff2.gif"><br />
		Click the following link and select 'Yes'.
		<em>
		<a href='javascript:navigator.registerContentHandler("application/vnd.mozilla.maybe.feed","<?php eh(Router::url('/',true)?>subscribe/?feedlink=%s","OpenFLP");'>Add OpenFLP to your Firefox2's feed readers list.</a></em>
	</p>
	</div>
</div>
