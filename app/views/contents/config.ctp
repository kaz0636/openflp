<div id="config" style="padding:0 10px;width:95%">
<h2 style="margin-top:0">OpenFLP Settings</h2>
<form action="/api/config/save" method="post"
 style="clear:both;width:100%;display:block"
 id="config_form"
 onreset="Form.fill(this, Config);return false">
	<div class="tabs">
		<div id="tab_config_basic" class="tab tab-active" rel="tab:config_form>config_basic">General</div>
		<div id="tab_config_view" class="tab" rel="tab:config_form>config_view">Display</div>
		<div class="tab" rel="tab:config_form>config_pin">Pin</div>
		<div class="tab" rel="tab:config_form>config_share">Share</div>
		<div class="tab" rel="tab:config_form>config_detail">Detail</div>
	</div>
	<div id="config_container" style="clear:both"><center>
		<div id="config_basic" style="display:none">
		<table>
			<tr>
				<th><a href="/subscribe/">Subscribe to feed</a></th>
				<td>Click 'Add' icon and enter the feed URL. </td>
			</tr>
			<tr>
				<th><a href="#manage" onclick="init_manage();return false">Manage subscription list</a></th>
				<td>Click 'Edit' icon to manage 'My Feeds'.</td>
			</tr>
			<tr class="last">
				<th><a href="/utility/bookmarklet/">Browser buttons</a></th>
				<td>Add new feeds to your subscription list with an easy-access browser button.</td>
			</tr>
		</table>
		</div>
		<div id="config_view" style="display:none">
		<table>
			<tr>
				<th>Font size</th>
				<td><input type="text" size="4" name="current_font"> px</td>
			</tr>
			<tr>
				<th>Sort order</th>
				<td>
				<input type="radio" name="reverse_mode" value="0">New articles first<br>
				<input type="radio" name="reverse_mode" value="1">Old articles first
				</td>
			</tr>
			<tr>
				<th>Number of 'My Feeds' to show</th>
				<td>
					<p>For shorter loading time, set the limit smaller. </p>
					<input type="radio" name="use_limit_subs" value="1">Set limit to <input type="text" name="limit_subs" value="100" size="4"> feeds<br>
					<input type="radio" name="use_limit_subs" value="0">Display all <br>
				</td>
			</tr>
			<tr>
				<th>Highlight</th>
				<td>
				Highlight selected article when using keyboard shortcuts.<br>
				<input type="radio" name="use_scroll_hilight" value="1">Enable<br>
				<input type="radio" name="use_scroll_hilight" value="0">Disable
				</td>
			</tr>
			<tr><th>Number of new articles per page</th>
				<td>
				Number of articles to open when you first click on a feed.<br>
				<input type="text" value="200" name="max_view" size="4"> articles (max: 200)</td>
			</tr>
			<tr><th>Number of old articles per page</th>
				<td>
				 Number of articles to open when you click "older".<br>
				<input type="text" value="20" name="items_per_page" size="4"> articles (max: 200)</td>
			</tr>
		</table>
		</div>

		<div id="config_detail" style="display:none">
		<table width="100%">
			<tr>
				<th>When to mark a feed as read<td>
				<ul>
					<li><input type="radio" name="touch_when" value="onload">Immediately after loading.</li>
					<li><input type="radio" name="touch_when" value="onclose">When moving to the next feed.</li>
					<li><input type="radio" name="touch_when" value="manual">When marked as read.</li>
				</ul>
			 </td>
			</tr>
			<tr>
				<th>Prefetching<td>
				Set the number of feeds to prefetch<br>
				<input type="radio" name="use_prefetch_hack" value="1"> 
				<input type="text" name="prefetch_num" size="2"> items (max: 5)<br>
				<input type="radio" name="use_prefetch_hack" value="0">Use default setting
			 </td>
			</tr>
			<tr>
				<th>Scroll speed</th>
				<td>
				Scroll speed when using keyboard shortcuts<br>
				<input type="radio" name="use_wait" value="1">Enable: <input type="text" value="200" size="6" name="wait"> milliseconds<br>
				<input type="radio" name="use_wait" value="0">Disable
				</td>
			</tr>
			<tr>
				<th>Scroll control</th><td>
				Scroll unit (via space key)<br>
				<input type="radio" name="scroll_type" value="page">One screen<br>
				<input type="radio" name="scroll_type" value="half">Half screen<br>
				<input type="radio" name="scroll_type" value="px">Precisely <input type="text" name="scroll_px" value="100" size="6"> px
			</td></tr>
			<tr><th>Automatic update of 'My Feeds'</th><td>
				<input type="radio" name="use_autoreload" value="1">Enable: Reload every <input type="text" name="autoreload" value="" size="6"> seconds. (min: 60 secs)<br>
				<input type="radio" name="use_autoreload" value="0">Disable
			</td></tr>
		</table>
		</div>

		<div id="config_pin" style="display:none">
		<table width="100%">
			<tr>
				<th>Pin backup</th>
				<td>
					Let OpenFLP remember your pin state (up to 100 changes).<br>
					<input type="radio" name="use_pinsaver" value="1">Enable<br>
					<input type="radio" name="use_pinsaver" value="0">Disable<br>
				</td>
			</tr>
			<tr>
				<th>Open limitation</th>
				<td>Open <input type="text" size="4" name="max_pin"> tabs at a time.</td>
			</tr>
			<tr>
				<th>Pop-up window </th>
				<td>
					To open articles with 'Pin' function, please set your browser to allow pop-ups on "<?php eh(Router::url('/',true))?>".<br>
				<a href="#" onclick="(3).times(function(){window.open()});return false;">Click on this link to test if pop-ups are enabled(3 new windows will open on success).</a></td>
			</tr>
		</table>
		</div>
		<div id="config_share" style="display:none">
		<table width="100%">
			<tr>
				<td colspan="2">
					<p>
					To share your subscriptions with others, configure <a href="/share/">Manage Sharing</a>.<br>
					</p>
				</td>
			</tr>
			<tr>
				<th>Sharing subscriptions</th>
				<td>
					<?php if (!empty($member)): ?>
					If you enable sharing, others can read your public subscriptions at "<?php eh(Router::url(array('controller' => 'public', 'action' => $member['Member']['username']),true))?>"
					<?php endif; ?>
					<?php $member_public = !empty($member['Member']['public'])?>
					<?php if ($member_public): ?>
						(<a href="/user/<?php eh($member['Member']['username'])?>">Show public subscriptions</a>)
					<?php endif; ?>
					<br>
					<input type="radio" name="member_public" value="1" <?php $member_public ? 'checked' : '' ?>> Enable Sharing<br>
					<input type="radio" name="member_public" value="0" <?php $member_public ? '' : 'checked' ?>> Disable Sharing<br>
				</td>
			</tr>
			<tr>
				<th>Default</th>
				<td>
					Default setting for new subscriptions<br>
					<input type="radio" name="default_public_status" value="1"> Public<br>
					<input type="radio" name="default_public_status" value="0"> Private<br>
				</td>
			</tr>
		</table>
		</div>

		<div id="config_submit">
		<table>
			<tr class="submit"><td>
				<center>
				<input type="reset" value="Cancel">
				<input type="submit" value="Save">
				</center>
			</td></tr>
		</table>
		</div>
		</center>
	</div>
</form>
<h2>Import / Export Subscription List</h2>
<table class="link">
<tr><th nowrap style="padding : 0 10px"><a href="/import/">Import</a>(not yet supported)</th>
	<td>Import OPML subscription list to OpenFLP.</td>
<tr><th nowrap style="padding : 0 10px"><a href="/export/opml" target="_self">Export</a>(not yet supported)</th>
	<td>Create backup of current subscription list in OPML. Follow the link and select 'Save'.</td>
</table>
</div>

