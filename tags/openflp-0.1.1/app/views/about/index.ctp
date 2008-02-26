<div id="content" class="page_about">
<div id="content-inner">

<script type="text/javascript">
var Language = 'English';
</script>

<?php if ($is_feedlink && $feed): ?>
<?php $avg_rate = $Subscription->average($Feed->id)?>
<?php $subscribed = $Member->subscribed($Feed->id)?>

<h2>Feed Infomation</h2>
<div class="feedinfo">
	<div class="feed_info">
	<div class="channel">
		<h3 style="background-image:url('<?php eh($Feed->icon())?>')">
			<a href="<?php eh($feed['Feed']['link'])?>" id="feed-title"><?php eh($feed['Feed']['title'])?></a>
		</h3>
		<div class="description"><?php eh($feed['Feed']['description'])?></div>
	</div>
	<ul>
		<li class="feedlink">
			<a href="<?php eh($feed['Feed']['feedlink'])?>"><?php eh($feed['Feed']['feedlink'])?></a>
			<span class="subscribe_button">
		<?php if (!$Member || !$subscribed): ?>
			<a href="/subscribe/<?php eh($feed['Feed']['feedlink'])?>" class="subscribe_link">subscribe this feed</a>
		<?php endif; ?>
		<?php if ($subscribed): ?>
			<span class="subscribed">[subscribed]</span>
			<button class="subs_edit" rel="edit:<?php eh($subscribed['Subscription']['id'])?>" onkeydown="subs_edit.call(this,event)" onmousedown="subs_edit.call(this,event)" onclick="return false">edit</button>
		<?php endif; ?>
			</span>
		</li>
		<li class="subscribers_count"><?php $basics->users($feed['Feed']['subscribers_count'])?></li>
		<li class="avg_rate">rate average <?php $basics->rateImage($avg_rate)?> <span id="avg-rate"><?php eh($avg_rate)?></span></li>
	</ul>
	</div>
</div>

<?php elseif (isset($Feeds)): ?>
	<% @seen = {} %>
	<% if feeds.size > 1 %>
		<h2>select feed</h2>
	<% else %>
		<h2>About this feed</h2>
	<% end %>
	<div class="feedinfo">
	<ul class="feedlist">
		<% @feeds.each do |feed, i| %>
		<% unless @seen[feed.feedlink] %>
			<% @seen[feed.feedlink] = true %>
			<li class="list<% if i == 0 -%> list-first<% end %>">
				<a href="/about/<%=h feed.feedlink %>"><%=h feed.title %></a>
				<span class="subscriber_count"> (<%= disp_users(feed.subscribers_count) %>)</span>
				<br>
				<a href="/about/<%=h feed.feedlink %>" class="feedlink"><%=h feed.feedlink %></a>
			</li>
        <% end %>
		<% end %>
	</ul>
    <% end %>
<?php endif; ?>

<?php
$conditions = array();
$conditions[] = es('Subscription.feed_id = %s', $Feed->id);
$subs = $Subscription->findAll($conditions);
?>
<?php if (count($subs) > 0): ?>
	<div class="subscribers">
	<h3>Subscribers with Public Profiles</h3>
	<ul class="subscribers_list">
		<?php foreach ($subs as $i => $sub): ?>
		<?php $subscriber = $Member->findById($sub['Subscription']['member_id'])?>
		<?php $Member->set($subscriber)?>
		<li class="<?php eh($i % 2 ? 'odd' : 'even')?>"><dl>
			<dt>
				<a href="/user/<?php eh($subscriber['Member']['username'])?>"><?php eh($subscriber['Member']['username'])?></a>
			</dt>
			<dd>
				<span class="subscribe_date">
					date: <?php eh(date('Y/m/d', strtotime($subscriber['Member']['created_on'])))?> | 
					Total Subscriptions <b><?php eh($Member->totalSubscribeCount())?></b> |
					Public Subscriptions <b><?php eh($Member->publicSubscribeCount())?></b>  
				</span>
			</dd>
		</dl><div style="clear:left;height:0px;font-size:1px"></div></li>
		<?php endforeach; ?>
	</ul>
	</div>
<?php endif; ?>

</div><!-- /content-inner -->
<div style="clear:both;"></div>
</div><!-- /content -->

