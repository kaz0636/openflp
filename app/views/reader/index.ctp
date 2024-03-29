<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="content-script-type" content="text/javascript">
	<title>OpenFLP</title>
	<link rel="stylesheet" href="/css/common.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="shortcut icon" href="/favicon.ico">
</head>
<script type="text/javascript">
var ApiKey = "<?php eh(session_id())?>";
var Language = 'English';

function ads_mouseover(){
	if(typeof Element == 'object'){
		Element.show('ads_top_description');
	 	setStyle('ads_top_description',{
	 		top   : $('container').offsetTop + 'px',
	 		width : this.offsetWidth - 10 + 'px'
 		})
 	}
}
function ads_mouseout(){
	if(typeof Element == 'object'){
		Element.hide('ads_top_description')
	}
}
</script>
<style type="text/css">
html{
	height : 100%;
	margin  : 0px;
	padding : 0px;
	overflow : hidden;
}
body{
	margin : 0;
	padding : 0;
	font-family:Arial, Helvetica, sans-serif;
	width : 100%;
	height : 100%;
	overflow : hidden;
}
#help_window{
	background : #fff;
	border : 2px solid #4889fd;
	padding : 10px;
	font-size : 12px;
}
.item_read *{
	color : gray !important;
}

.menu-focus{
	background-color : #b6bdd2;
}
#right_bottom{
}

#guide_button{
	height : 20px;
	position : relative;
	border-top : 2px solid #fff;
	border-bottom : 2px solid #a5c5ff;
	background-image:url('/img/icon/compus.gif');
	padding-left : 28px;
	white-space : nowrap;
	width : 40px;
}
#guide_button .bottom{
	position : absolute;
	left : 25px;
	bottom : 1px;
	line-height : 20px;
	padding-top : 4px;
	white-space : pre;
}

.item{
	margin : 0 10px 0 10px;
	z-index : 1;
	border-bottom : 2px solid #a5c5ff;
}
.pin_active {
	border: 1px solid #000;
	border-color: #808080 #ffffff #ffffff #808080;
	background : #e8e8e8;
}
.clip_active {
	border: 1px solid #000;
	border-color: #808080 #ffffff #ffffff #808080;
	background : #e8e8e8;
}
.pin_item {
	overflow : hidden;
	height : 15px;
	width : 276px;
	white-space : nowrap;
}

.pinned {
	/*border-left : 3px solid #F44;*/
}
.pinned .padding{
	background : #fff0f0 !important;
	border: 2px solid #fff0f0;
}
.padding{
	margin : 2px 0;
	border: 2px solid #fff;
}

.hilight {
	border: 2px solid #cee1ff !important;
	background: #ffffe0;
	/*background : #ffffcc !important;*/
}
#message{
	/*font-family : monospace;*/
}
#control .tri_icon{
	margin-left: 4px;
	background-image : url('/img/icon/tri_d.gif');
	background-position : 0 50%;
	background-repeat : no-repeat;
}
.feed_navi{
	text-align : right;
	height  : 26px;
	padding : 0;
	font-size : 12px;
	line-height : 22px;
	vertical-align : middle;
	color : #042e9a;
}
.feed_navi span{
	cursor : pointer;
}
.feed_navi .disable{
	display : none;
}
/* clip */
table.compact{
	margin : 0;
	padding : 0;
	width : 90%;
}
table.compact th{
	text-align : right;
	padding-right : 10px;
}
table.compact td{
}
table.compact input, table.compact textarea{
	width : 99%;
}
#config_form optgroup{
	font-style : normal;
}
#config_form fieldset{
	border : none;
}
#config_form dt{
	font-weight : bold;
}
#config_form dd{
	padding : 0 0 0 0;
	margin : 3px 0 3px 10px;
}
#config_form li{
	margin : 0;
	padding : 0;
	line-height : 100%;
}
</style>
<!--[if IE 7]>
<style>
#my_menu{
	font-size: 13px;
}
#menu_button span{
	line-height:22px;
}
#up_button, #down_button, #myclip_button, #keyhelp_button, #pin_button{
	width : 26px;
	padding : 0 !important;
	line-height : 0px !important;
	font-size  :1px !important;
}
#keyhelp_button{
	width : auto !important;
	padding-left: 26px !important;
	line-height : 22px !important;
	font-size: 12px !important;
}
#pin_button{
	width : 26px;
	font-size  :12px !important;
}
.pin_item{
	line-height : 1.5;
	height: 24px !important;
}

#myclip_button img{
	margin : 2px 3px;
}
#menu_button{
	height : 10px;
}
#menu_button span{
	height : 20px;
	margin : 0;
	line-height : 20px !important;
}
</style>
<![endif]-->

<body><base target="_blank">

<!-- header -->
<div id="header" style="height:0px;display:none"></div>
<!-- /header -->

<!-- menu -->
<div id="menu" style="position:relative;width:100%;height:32px;">
<table width="100%" style="position:absolute;margin:1px 0 0 0;padding:0" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td nowrap style="width:260px;height:32px;padding:4px 0;margin:0;text-align:left;white-space:nowrap;" valign="top">
			<div id="reader_logo">
				<a href="/" target="_self"><img src="/img/logo_small.gif" border="0"></a>
			</div></td>
		<td valign="top" style="position:relative;padding-top:0px;padding-left:5px;vertical-align:top;" nowrap>
			<div id="message_box" style="position:absolute;margin-top:4px;z-index:10"><form style="display:inline;margin:0;padding:0" onsubmit="return false">
				<table cellpadding="0" cellspacing="0"><tr>
				<td valign="bottom" style="padding-right:7px">
					<span id="loading" onclick="show_tips()">
					<img id="loadicon" src="/img/icon/loading.gif" width="19" height="19">
					</span> &lt; 
				</td>
				<td nowrap>
					<span class="alert" id="message" style="background:#fff;font-size:12px;padding:0;">
						welcome
					</span>
				</td></tr>
				</table>
			</form></div>
		</td>
	</tr>
</table>

	<table style="position:absolute;right:0;top:0;width:70%">
	<tr>
	<td align="right" nowrap  style="padding-left:12px;padding-top:2px;vertical-align:top;">
		<div id="my_menu" style="line-height:100%;padding:4px 6px 0px 0;text-align:right">
			<span id="welcome">welcome <a href="/user/<?php eh($member['Member']['username'])?>"><?php eh($member['Member']['username'])?></a></span>
			|&nbsp;<a href="#config" onclick="init_config();return false">Settings</a>&nbsp;
			|&nbsp;<a href="/account/" target="_self">Account</a>&nbsp;|&nbsp;<a href="/logout" target="_self">Sign Out</a>
		</div>
	</td></tr>
	</table>
</div>
<!-- /menu -->
<!-- control -->
<div id="control" style="height:28px;margin-left:262px;border-bottom:1px solid #ccc; margin-bottom: 2px;position:relative;background:#f1f1f1">

	<div style="position:absolute;left:0px;" id="control_buttons" class="buttons">
		<ul id="control_buttons_ul">
			<li class="button icon" id="pin_button"
			 onmouseover="Control.pin_hover.call(this,event);"
			 onmouseout="Control.pin_mouseout.call(this,event);"
			 onclick="Control.pin_click.call(this,event);"
			 style="background-image:url('/img/icon/pin.gif')" >&nbsp;<span id="pin_count"></span></li>
			<li class="button icon" id="keyhelp_button" onclick="Control.toggle_keyhelp()" style="background-image:url('/img/icon/key_q.gif');width:auto;padding-left:26px;">&nbsp;Shortcut Keys<kbd>?</kbd></li>
			<li class="button icon" id="menu_button"
			 style="text-align:right;width:auto;"
			 onselectstart="return false"
			 onmousedown="Control.toggle_menu.call(this,event);"
			 ><span style="white-space:nowrap;">Others<span class="tri_icon">&nbsp;&nbsp;</span></span>
			</li>
		</ul>
	</div>
        <span style="display:none" id="unread-item-count">[% get_unread_count %]</span>
	<small id="total_unread_count" style="font-size:12px;position:absolute;right: 70px;"></small>
	<div class="fontpad">
		<img src="/img/icon/text_small.gif" rel="Control:font(-1)">
		<img src="/img/icon/text_default.gif" rel="Control:font(0)">
		<img src="/img/icon/text_big.gif" rel="Control:font(1)">
	</div>
</div>
<!-- /control -->

<noscript>
	<!-- This is best practice of centering -->
	<center style="padding-top:1em">
	To use OpenFLP, enable JavaScript by changing your browser options.
	</center>
</noscript>


<div id="container" style="display:none">
<div id="left_container">
	<div id="left_body">
		<div id="subs_tools">
			<div class="toolbar" id="subs_buttons" style="padding : 6px 12px 0 12px;">
				<table width="100%" height="20px"><tr>
					<td width="30%">
						<div onclick="Control.reload_subs()" id="reload_button" class="button" style="background-image:url('/img/icon/reload.gif')">Reload</div>
					</td>
					<td width="30%">
						<div class="button" onclick="init_manage()" style="background-image:url('/img/icon/mylist.gif')">Edit</div></td>
					<td width="30%"><div class="button" onclick="Control.show_subscribe_form()"  style="background-image:url('/img/icon/add.gif')">Add</div></td>
				</tr></table>
			</div>
			<div class="toolbar" id="subs_toolbar" style="padding-left:12px;padding-bottom:4px">
				<table width="100%" height="20px"><tr>
					<td width="25%" valign="bottom" >
						<div class="button" id="viewmode_toggle"
						onselectstart="return false"
						onmousedown="ViewmodeToggle.click.call(this,event);return false"
						><b id="mode_text_view" style="font-weight:normal">mode</b><span class="tri_icon">&nbsp;&nbsp;</span>
						</div>
					<td width="25%" valign="bottom">
						<div class="button" id="sortmode_toggle"
						onmousedown="SortmodeToggle.click.call(this,event)"><b id="mode_text_sort" style="font-weight:normal">sort</b><span class="tri_icon">&nbsp;&nbsp;</span>
						</div>
					<td valign="bottom">
						<div class="button" id="show_all_button"
						onclick="Control.toggle_show_all.call(this,event);show_all_mouseover.call(this,event);"
						onmouseover="show_all_mouseover.call(this,event);"
						onmouseout="show_all_mouseout.call(this,event)"
						></div>
				 </tr></table>
			</div>
			<div class="toolbar" id="subs_search">
				<div id="search_box_container"><img src="/img/icon/search_left.gif"><input type="text" id="finder" class="quickfind" value="" autocomplete="off"></div>
			</div>
		</div><!-- /subs_tools -->
		<div id="subs_container">
			<div id="subs_body" class="folder">
				<div class="wait">loading feeds</div>
			</div>
		</div>
	</div>
</div><!--/left_container-->

<div id="right_container" style="display:none">
	<div id="buffer"></div>
	<div id="right_top_navi" class="subs_navi"></div>
	<div id="right_body"></div><!-- /right_body -->

	<div id="right_bottom" style="clear:both">
		<div id="right_bottom_navi" class="subs_navi"></div>
		<div class="ads" id="ads_bottom" style="margin:30px 0;border-top:1px dotted #cacaca;line-height:16px"></div>
		<br clear="all">
		<div id="feed_paging" class="feed_navi">
			<span id="feed_paging_prev" class="button" rel="Control:feed_page(-1)" style="padding:4px 5px 0px 5px">≪ Newer</span><span id="feed_paging_next" class="button" style="border-left:3px double #888;padding:4px 5px 0px 5px" rel="Control:feed_page(1)">Older ≫</span>
		</div>
		<div id="scroll_padding"></div>
	</div><!-- /right_bottom -->
</div><!-- /right_container -->


</div><!-- /container -->

<div id="error_window" style="display:none">
	<h2 id="error_title"></h2>
	<div id="error_body"></div>
	<div class="close">
		<span class="button" onclick="Element.hide('error_window')">Close</span>
	</div>
</div>
<div id="subscribe_window">
	<div class="tabs">
		<div class="tab tab-active" id="tab_add_feed" rel="tab:subscribe_window>add_feed">add feed</div>
		<div class="tab tab-inactive" rel="tab:subscribe_window>import_feed">import feed</div>
	</div>
	<div class="body">
		<div id="add_feed">
			<form id="discover_form" action="/api/feed/discover" method="post">
				<b>Feed URL</b> : <input type="text" name="url" style="width:280px" id="discover_url" value="http://">
				<input type="submit" value="next" style="width:90px">
			</form>
			<div id="discover_items"></div>
			<div style="float:left" class="discover_help">
				<a href="/subscribe/"><img src="/img/icon/new_window.gif" border="none"></a>
			</div>
		</div>
		<div id="import_feed" style="display:none">
			<form target="_blank" action="/import/index" method="post" enctype="multipart/form-data">
				<b>file</b> : <input type="file" name="opml" style="width:230px"> <input type="submit" value=" Upload " style="width:90px">
			</form>
			<form target="_blank" action="/import/fetch" method="post" enctype="multipart/form-data">
				<b>OPML URL</b> : <input type="text" name="opml_url" value="http://" style="width:280px"> <input type="submit" value=" Import from URL " style="width:90px">
			</form>
			<div style="float:left" class="discover_help">
				<a href="/import/"><img src="/img/icon/new_window.gif" border="none"></a>
			</div>
		</div>
		<div class="close">
			<span class="button" onclick="Control.hide_subscribe_form()">Close</span>
		</div>
	</div>
</div>

<div style="display:none;position:absolute;right:79px;background:#f0f0f0;padding:5px;top:0px;font-size:12px;border:1px solid #4889fd" id="ads_top_description">[% ad.description | html %]</div>

<div id="keyhelp">
	<h2>Shortcut Keys<kbd>?</kbd></h2>
	<div id="keybind_table"></div>
	<p class="notice">
	</p>
</div>

<div id="mini_window">
	<div id="mini_window_header"><span class="button" onmousedown="DOM.hide('mini_window')">x</span></div>
	<div id="mini_window_container">
		<div id="mini_window_body"></div>
	</div>
</div>
<div id="help_window" style="position:absolute;display:none">

</div>

<div id="footer" style="height:0px;display:none;font-size:0px;margin:0;padding:0;border:none"></div>

<!-- TEMPLATE -->
<!-- not subscribed -->
<textarea class="template" id="discover_select_sub">
<div class="discover_item">
	<div style="float:right" id="" class="[[ subscribed ]]">
		<a href="[[feedlink]]" rel="subscribe" class="sub_button">Add</a><br>
	</div>
	<img src="/favicon/[[feedlink]]" width="16" height="16"> <a href="[[link]]">[[title]]</a>
	&nbsp;|&nbsp;&nbsp;<b style="color:#717578">[[subscribers_count]]</b><span style="color:#717578"> [[users]]</span>
	<br>
	<small><a href="[[feedlink]]" class="feedlink">[[feedlink]]</a></small>
</div>
</textarea>
<!-- subscribed -->
<textarea class="template" id="discover_select_unsub">
<div class="discover_item">
	<div style="float:right" id="" class="[[ subscribed ]]">
		<a href="[[feedlink]]" rel="unsubscribe" class="unsub_button">Unsubscribe</a><br>
	</div>
	<img src="/favicon/[[feedlink]]" width="16" height="16"> <a href="[[link]]">[[title]]</a>
	&nbsp;|&nbsp;&nbsp;<b style="color:#717578">[[subscribers_count]]</b><span style="color:#717578"> [[users]]</span>
	&nbsp;<span style="color:red">[Subscribed]</span><br>
	<small><a href="[[feedlink]]" class="feedlink">[[feedlink]]</a></small>
</div>
</textarea>

<textarea class="template" id="subscribe_item">
<span style="background-image:url('[[icon]]')"
 id="subs_item_[[ subscribe_id ]]"
 class="treeitem [[ classname ]]"
 onmouseover="SubsItem.onhover.call(this,event)"
 onmouseout="SubsItem.onunhover.call(this,event)"
 rel="Control:read('[[ subscribe_id ]]')"
 subscribe_id="[[subscribe_id]]">
 [[ title ]] ([[ unread_count ]])
</span>
</textarea>

<!-- フォルダ表示モード  -->
<textarea class="template" id="subscribe_folder" style="">
<span class="folderitem [[ classname ]]">[[ name ]] ([[ unread_count ]])</span>
</textarea>

<!-- channel info -->
<textarea class="template" id="inbox_feed">
<div class="channel"  style="margin:0 10px;padding:0">
	<h1 class="title" style="margin:2px 10px 2px 10px;padding:10px 0 8px 0">
		<div>
		<table style="width:98%">
			<tr>
				<td width="95%"><a href="[[ link ]]">[[ title ]]</a></td>
				<td rowspan="2" valign="top">[[ image ]]</td>
			</tr>
			<tr>
				<td style="padding-top:6px;"><small class="description" style="padding:0;margin:0;line-height:16px">[[ description ]]</small></td>
			</tr>
		</table>
		</div>
	</h1>
</div>
<div class="channel_toolbar" style="margin:0 10px">
	<table align="right"><tr>
		<td nowrap style="padding-right:10px">
			<span class="channel_folder" style="background:url('/img/icon/close.gif') no-repeat;padding-left:20px"
				onselectstart="return false"
				onmousedown="FolderToggle.click.call(this,event);return false"
				class="button move" id="folder_label">[[ folder ]] <img src="/img/icon/tri_d.gif"></span>
		</td>
		<td style="padding-right:15px;position:relative"><img id="rate_img" class="rate_pad" src="/img/rate/pad/[[ rate ]].gif" sid="[[subscribe_id]]" onclick="Rate.click.call(this,event)" onmouseout="Rate.out.call(this,event)" onmousemove="Rate.hover.call(this,event)"></td>
		<td nowrap>
			<span id="feed_prev" title="Show newer items" class="button" rel="Control:feed_page(-1)">&lt;</span>
			<span id="feed_next" title="Show older items" class="button" rel="Control:feed_page(1)">&gt;</span>
		</td>
	</table>
	<table><tr>
		<td valign="bottom" nowrap style="padding:0 6px;line-height:22px;height:22px;overflow:hidden" id="channel_info">[[ widgets ]]</td>
	</tr></table>
	<div style="clear:both;font-size:1px;height:1px"></div>
</div>

<div class="footer" style="position:relative;clear:both">
</div>
[[ items ]]
</textarea>

<!-- adfeeds -->
<textarea class="template" id="inbox_adfeeds">
<div class="channel"  style="margin:0 10px;padding:0">
	<h1 class="title" style="margin:2px 10px 2px 10px;padding:10px 0 8px 0">
		<div>
		<table style="width:98%">
			<tr>
				<td width="95%"><a href="[[ link ]]">[[ title ]]</a></td>
				<td rowspan="2" valign="top">[[ image ]]</td>
			</tr>
			<tr>
				<td style="padding-top:6px;"><small class="description" style="padding:0;margin:0;line-height:16px">[[ description ]]</small></td>
			</tr>
		</table>
		</div>
	</h1>
</div>
<div class="channel_toolbar channel_adfeeds" style="margin:0 10px">
	<table><tr>
		<td valign="bottom" nowrap style="padding:0 6px;line-height:22px;height:22px;overflow:hidden" id="channel_info">
			これはスポンサーフィードです。あと[[ads_expire]]日で自動的に解除されます。
			<a href="/subscribe/[[ feedlink ]]">このフィードを購読する</a>
		</td>
	</tr></table>
	<div style="clear:both;font-size:1px;height:1px"></div>
</div>
<div class="footer" style="position:relative;clear:both">
</div>
[[ items ]]
</textarea>

<!-- item -->
<textarea class="template" id="inbox_items">
<div class="item [[loop_context]] [[pinned]]" id="item_[[id]]">
	<div class="padding" id="item_count_[[ item_count ]]">
	<div class="item_header">
		<div class="item_buttons" style="float:right;padding-right:4px;padding-top:4px">
			<span id="pin_[[id]]" style="display:block;width:18px;height:18px;margin-right:4px;float:left;" class="[[pin_active]]"><img onmousedown="toggle_pin([[id]])" src="/img/icon/pin.gif"></span>
			<img onmousedown="Control.close_and_next_item([[id]],event)" src="/img/icon/batu.gif">
		</div>
		<h2 class="item_title" id="head_[[id]]" count="[[ item_count ]]">
			<a href="[[ link ]]">[[ title ]]</a>
		</h2>
	</div>
	<div class="item_info">
		<a href="[[ link ]]" target="blank">Permalink</a> | 
		<small class="rel">[[ relative_date ]]</small>
		<small class="author">[[ author ]]</small>
		<small class="category">[[ category ]]</small>
		<small class="enclosure">[[ enclosure ]]</small>
	</div>
	<div class="item_body" id="item_body_[[id]]">
		<div class="body">[[ body ]]</div>
	</div>
	<div class="item_footer">
		<div class="entry_widgets">[[ widgets ]]</div>
	</div>
	</div>
</div>
</textarea>

<!-- clip register -->
<textarea class="template" id="clip_register">
	<div class="clip_register">
		<div style="border : 3px solid #F44;padding:10px;background:#fff">
		この機能を使うには「<a href="http://clip.livedoor.com/">livedoor クリップ</a>」の利用登録が必要です。
		</div>
	</div>
</textarea>

<!-- clip info -->
<textarea class="template" id="clip_info">
[[#{ public_clip_count ? ['<a href="', clip_page_link(link), '" target="_blank"><b>', public_clip_count, '</b> ', (public_clip_count > 1 ? 'users' : 'user'), '</a>'].join("") : "" }]] ｜ [[#{ new DateTime(created_on * 1000).ymd_jp() + "にクリップ済み" }]]
</textarea>

<!-- clip form -->
<textarea class="template" id="clip_form">
	<div class="clip_form_body">
	<form id="clip_form_[[id]]" class="clip_form" target="_blank" method="post" action="/clip/add">
		<div class="rate_pad_wrapper"><img id="clip_rate_[[id]]" class="rate_pad" src="/img/rate/pad/0.gif" item_id="[[id]]" onclick="ClipRate.click.call(this,event)" onmouseout="ClipRate.out.call(this,event)" onmousemove="ClipRate.hover.call(this,event)"></div>
		<h3>Bookmark
			<span id="clip_info_[[id]]"></span>
		</h3>
		<input type="hidden" name="title" value="[[title]]">
		<input type="hidden" name="link" value="[[link]]">
		<input type="hidden" name="rate" value="">
		<input type="hidden" name="from" value="reader">
		<table class="compact">
			<tr>
				<th width="80">Tag</th>
				<td><input type="text" name="tags" value="[[tags]]" onkeypress="(event.keyCode==27)&&clip_click([[id]])" onkeyup="(event.keyCode==27)&&clip_click([[id]])"></td>
			</tr>
			<tr>
				<th width="80">Comment</th>
				<td>&lt;textarea name="notes"&gt;[[notes]]&lt;/textarea&gt;</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td style="font-size:90%">
					<input type="submit" value="Bookmark" class="clip_submit">
					<select name="public">
						<option value="on" selected>Public</option>
						<option value="off">Private</option>
					</select>
				</td>
			</tr>
		</table>
	</form>
	</div>
</textarea>

<textarea class="template" id="folder_item">
<span class='button flat_menu [[ checked ]]'
 onmouseout='MenuItem.onunhover.call(this,event)'
 onmouseover='MenuItem.onhover.call(this,event)'
 onmouseup='Control.move_to("[[ move_to ]]");FlatMenu.hideAll()'
 rel=''>[[ folder_name ]]</span>
</textarea>

<textarea class="template" id="pin_item">
<span class='button flat_menu pin_item [[target]]' 
 style="background-image:url('[[icon]]');background-repeat:no-repeat;background-position:2px 3px;"
 onmouseout='PinItem.onunhover.call(this,event)'
 onmouseover='PinItem.onhover.call(this,event)'
 onmouseup='Control.read_pin("[[ link ]]");FlatMenu.hideAll()'
>[[ title ]]</span>
</textarea>

<textarea class="template" id="menu_item">
<span class='button flat_menu' style="background-repeat:no-repeat;background-position:2px 3px;padding-left:8px"
 onmouseout='MenuItem.onunhover.call(this,event)'
 onmouseover='MenuItem.onhover.call(this,event)'
 onmouseup='[[action]]'
>[[ title ]]</span>
</textarea>

<textarea class="template" id="viewmode_item">
<span class='button flat_menu [[ checked ]]'
 onmouseout='MenuItem.onunhover.call(this,event)'
 onmouseover='MenuItem.onhover.call(this,event)'
 onmouseup='Control.change_view("[[ mode ]]");FlatMenu.hideAll()'
 rel=''>[[ label ]]</span>
</textarea>

<textarea class="template" id="sortmode_item">
<span class='button flat_menu [[ checked ]]'
 onmouseout='MenuItem.onunhover.call(this,event)'
 onmouseover='MenuItem.onhover.call(this,event)'
 onmouseup='Control.change_sort("[[ mode ]]");FlatMenu.hideAll()'
 rel=''>[[ label ]]</span>
</textarea>
<!-- ADS -->
<textarea class="template" id="ads_body">
	<div>
		[[items]]
	</div>
</textarea>
<textarea class="template" id="ads_item">
</textarea>

<!-- /TEMPLATE -->

</body>
</html>
<script type="text/javascript" src="/js/fl_aio.js"></script>
<script type="text/javascript">init();</script>
