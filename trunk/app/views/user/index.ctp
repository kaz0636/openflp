<?php
if (!empty($member) && $member['Member']['username'] == $target['Member']['username']) {
    $is_owner = 1;
}
$Target = new Member;
$Target->set($target);
$total_subscribe_count = $Target->totalSubscribeCount();
$public_subscribe_count = $Target->publicSubscribeCount();
$recent_subs = $Target->recentSubs(10);
?>

<script type="text/javascript">
var Language = 'English';
var ApiKey = null;
</script>
<script type="text/javascript" src="/js/reader_subscribe.js"></script>

<div id="content" class="page_user">
<h2>User Information</h2>
<div id="content-inner">
<div class="user_info">

	<h3><?php eh($target['Member']['username'])?></h3>
		<?php if ($target['Member']['public'] && $is_owner): ?>
		<p>
			<a href="/share/">Manage Sharing</a>
		</p>
		<?php else: ?>
		<p>
			Share-setting is disabled. This page is not accessible to others.<br />
			You may set publicity of your subscription from "<a href="/share/">Manage Sharing</a>"
		</p>
		<?php endif; ?>

	<div class="user_stats">
		<ul>
			<li>Total Subscriptions : <span id="total_subscribe_count"><?php eh($total_subscribe_count)?></span></li>
			<li>Public Subscriptions : <span id="public_subscribe_count"><?php eh($public_subscribe_count)?></span></li> 
		</ul>
		<?php if ($target['Member']['public']): ?>
			<ul class="link_rss">
			<% if @target.public && public_subscribe_count %>
				<li><a href="/user/<%=h @target.username %>">Read public subscriptions</a></li>
				<li>
					<a href="/import/<%= url_for(:action => "/", :abs_path => false) %>/user/<%=h @target.username %>/opml">Import subscription list</a>
					<a href="/user/<%=h @target.username %>/opml"><img src="/img/icon/opml.gif" border="0"></a>
				</li>
			<% end %>
			</ul>
		<?php endif; ?>

	</div>
    <?php if (count($recent_subs)): ?>
	<div class="recent_subscribed">
		<h3>Recent Subscriptions</h3>
		<p>
			<?php eh($target['Member']['username'])?>'s recent public subscriptions.
		</p>
		<ul class="recent_feeds">
		<?php foreach ($recent_subs as $i => $sub): ?>
			<li class="<?php eh($i % 2 ? 'even' : 'odd')?>">
				<a href="<?php eh($sub['Feed']['link'])?>" style="background-image:url(/icon/<?php eh($sub['Feed']['id'])?>)" class="title"><?php eh($sub['Feed']['title'])?></a>
				<div class="description"><?php eh($sub['Feed']['description'])?></div>
				<ul class="info">
					<li class="date"><?php eh($sub['Subscription']['created_on'])?></li>
					<li>
						<a href="/about/<?php eh($sub['Feed']['feedlink'])?>"><?php $basics->users($sub['Feed']['subscribers_count'])?></a>
					</li>
					<li>
					<?php if ($Member->checkSubscribed($sub['Feed']['feedlink'])): ?>
					<span class="subscribed">[subscribed]</span>
					<button class="subs_edit" rel="edit:<?php eh($sub['Subscription']['id'])?>" onkeydown="subs_edit.call(this,event)" onmousedown="subs_edit.call(this,event)" onclick="return false">edit</button>
					<?php else: ?>
					<a href="/subscribe/<?php eh($sub['Feed']['feedlink'])?>" class="subscribe">add</a>
					<?php endif; ?>
					</li>
				</ul>
				<div style="clear:left"></div>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

</div>
</div>
</div><!-- /content -->
<div style="clear:both;"></div>

