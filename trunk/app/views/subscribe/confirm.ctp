<?php
$default_public = $Member->defaultPublic();
?>
<div id="content" class="page_subscribe">
<div id="content-inner">

<h2>Subscribe Feed</h2>

<form action="/subscribe/confirm" method="post" name="subscribe" onsubmit="subscribe_submit.call(this,event)">
<div class="subscribe_candidates">
	<h3>You can subscribe to</h3>
	<input type="hidden" name="feedlink" value="<?php eh($feedlink)?>" id="target_url">
	<input type="hidden" name="register" value="1">
	<input type="hidden" name="ApiKey" value="<?php eh(session_id())?>">
	<?php $not_subscribed = 0; ?>
	<?php $seen = array()?>
	<ul id="feed_candidates">
	<?php foreach ($feeds as $i => $feed): ?>
	<?php if (isset($seen[$feed['Feed']['feedlink']])) continue; ?>
	<?php $seen[$feed['Feed']['feedlink']] = true; ?>
	<?php $sub_id = !empty($feed['Feed']['subscribe_id']) ? $feed['Feed']['subscribe_id'] : 0; ?>
	<?php if (!empty($feed['Feed']['subscribe_id'])): ?>
		<li class="list<?php if ($i == 0): ?> list-first<?php endif; ?>">
			<a class="subscribe_list" style="background-image:url('/icon/<?php eh($feed['Feed']['id'])?>')" href="<?php eh($feed['Feed']['link'])?>"><?php eh($feed['Feed']['title'])?></a>
			<span class="subscriber_count"><?php $basics->usersLink($feed)?></span>
			<span class="subscribed">［subscribed］</span>
			<button class="subs_edit" rel="edit:<?php eh($sub_id)?>" onkeydown="subs_edit.call(this,event)" onmousedown="subs_edit.call(this,event)" onclick="return false">Edit</button>
			<button class="subs_delete" id="sub_<?php eh($sub_id)?>" onclick="subs_delete.call(this,event)">Delete</button>
			<br />
			<a href="<?php eh($feed['Feed']['feedlink'])?>" class="feedlink"><?php eh($feed['Feed']['feedlink'])?></a>
		</li>
	<?php else: ?>
		<li class="list<?php if ($i == 0): ?> list-first<?php endif; ?>">
			<input type="checkbox" name="check_for_subscribe[<?php eh($not_subscribed)?>]" value="<?php eh($feed['Feed']['feedlink'])?>"<?php if (count($feeds) == 1 || $i == 0): ?> checked<?php endif; ?>>
			<input type="hidden" name="feedlink" value="<?php eh($feed['Feed']['feedlink'])?>" />
			<a class="subscribe_list" style="background-image:url('/icon/<?php eh($feed['Feed']['id'])?>')" href="<?php eh($feed['Feed']['link'])?>"><?php eh($feed['Feed']['title'])?></a>
			<span class="subscriber_count"><?php $basics->usersLink($feed)?></span><br />
			<a href="<?php eh($feed['Feed']['feedlink'])?>" class="feedlink"><?php eh($feed['Feed']['feedlink'])?></a>
		</li>
		<?php $not_subscribed++; ?>
	<?php endif; ?>
	<?php endforeach; ?>
	</ul>
</div>

<?php if ($not_subscribed > 0): ?>
<div class="subscribe_option">
	<h3>Options</h3>
	<table>
		<tr><th>Folder</th>
		<td>
			<select name="folder_id" onchange="folder_change.call(this,event)">
			<option value="0" selected>Leave it uncategorized</option>
			<option value="-">Create new folder</option>
			<?php foreach ($member['Dir'] as $folder): ?>
			<option value="<?php eh($folder['id'])?>"><?php eh($folder['name'])?></option>
			<?php endforeach; ?>
			</select>
		</td></tr>
		<tr><th>Rating</th>
		<td>
			<select name="rate">
				<option value="0" selected>0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</td>
		</tr>
		<?php if ($member['Member']['public']): ?>
		<tr><th>Share</th>
		<td>
			<input type="radio" name="public" value="1" id="public_1" <?php eh($default_public ? 'checked' : '')?>><label for="public_1">Public</label>
			<input type="radio" name="public" value="0" id="public_0" <?php eh($default_public ? '' : 'checked')?>><label for="public_0">Private</label>
		</td>
		</tr>
		<?php endif; ?>
	</table>
	<div class="submit">
		<input type="submit" value="Subscribe" class="submit_button" id="submit_button">
		<input type="checkbox" id="history_back" style="display:none"><label for="history_back" id="label_history_back" style="display:none">back to the page</label>
	</div>
</div>
<?php endif; ?>

</div><!-- /end page -->

<div class="subscribe_help">
	<h3>Hint</h3>
	<p>
		You can subscribe to a feed from anywhere with the <a href="/utility/bookmarklet/">browser button</a>.
	</p>
</div>

</div><!-- /end container -->

</div><!-- /content-inner -->
</div><!-- /content -->

<script type="text/javascript">if(typeof init == "function") init();</script>
