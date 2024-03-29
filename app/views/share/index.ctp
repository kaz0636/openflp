<!--[if IE 7]>
<style>
#result{
	width: 100% !important;
}
</style>
<![endif]-->

<script type="text/javascript">
var Language = 'English';
</script>
<div id="content">
<div class="share">
<h2>Manage Sharing</h2>
<div class="share_body">
	<div class="status">
		<?php if ($member['Member']['public']): ?>
			<button onclick="set_member_public(0);return false">Disable Sharing</button>
		<?php else: ?>
			<button onclick="set_member_public(1);return false">Enable Sharing</button>
		<?php endif; ?>
		<ul>
			<li>Sharing: <span id="member_public"><?php eh($member['Member']['public'] ? 'ON' : 'OFF')?></span>
			<?php if ($member['Member']['public']): ?>(<a href="/user/<?php eh($member['Member']['username'])?>">Show public subscriptions</a>)<?php endif; ?>
			</li>
			<li>Public feeds: <span id="public_subs_count"></span></li>
		 	<li>Private feeds: <span id="private_subs_count"></span></li>
		</ul>
	</div>
	<div class="search_form">
		<form onsubmit="do_search();return false;">
		<table>
			<tr><td>Target</td>
			<td>
				<input type="radio" name="search_from" id="filter_from_all" checked>
				<label for="filter_from_all">All</label>
				<input type="radio" name="search_from" id="filter_from_public">
				<label for="filter_from_public">Public feeds</label>
				<input type="radio" name="search_from" id="filter_from_private">
				<label for="filter_from_private">Private feeds</label>
			</td></tr>
			<tr><td>Subscribers</td>
			<td>
				over <input type="text" value="" id="filter_subscriber_min" size="4"> subscribers and
				under <input type="text" value="" id="filter_subscriber_max" size="4"> subscribers
				(example: 	
					<span onclick="set_query({subscriber_max:'',subscriber_min:100});" class="query_sample">over 100 subscribers</span>
					<span onclick="set_query({subscriber_max:10,subscriber_min:''});" class="query_sample">under 10 subscribers</span>)
			</td></tr>
			<tr><td>Title or URL</td>
			<td><input type="text" value="" id="filter_string">
			</td></tr>
		</table>
		<div class="mspace">
		<table>
			<tr>
				<th>Folders (<span class="query_sample" onclick="mspace_reset('folder')">Select all</span>)</th>
				<th>Ratings (<span class="query_sample" onclick="mspace_reset('rate')">Select all</span>)</th>
			</tr>
			<tr>
				<td><div id="mspace_folders"></div></td>
				<td><div id="mspace_rate"></div></td>
			</tr>
		</table>
		</div>
		</form>
	</div>
	<h3>Result: <span id="filtered_subs_count"></span> <button class="select_all" onclick="select_all()">Select all</button></h3>
	<div class="buttons">
		<button onclick="set_public(1)">Set to Public</button><button onclick="set_public(0)">Set to Private</button>
		<span id="set_public_progress"></span>
	</div>
	<div id="filtered_subs"></div>
	<span id="show_all" onclick="show_all()">Display all</span>
</div>
</div>
</div>

<?php $basics->loadJS(array('reader_proto','reader_pref','reader_share'))?>
