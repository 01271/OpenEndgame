<?php
session_start();
function faker_form() {

	echo '<h3>Hide The Body Utility</h3>' .
	'hide your sharking by creating yourself a new and fake trade history.<br>' .
	'The purpose of this is to hide a specific shark attempt and make sure that there are \'legitimate\' trades around it.<br<br>' .
	'Ok, so I\'ve got your name from logging in, now I just need you to enter some additional info:<br>' .
	'<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><br><input name="demo" value="demo" type="submit"><input name="submit" value="submit" type="submit">';

}

function faker() {

	faker_header();

	$i = 0;

	while ($i <= 29) {
		faker_single($i);
		$i++;
	}

	faker_footer();

}

function faker_userids() {

	http://steamcommunity.com/groups/tf2bazaar/memberslistxml/?xml=1

}

function faker_single($num) {

	echo
	'<div class="tradehistoryrow ' . (($num % 2 == 0) ? 'even' : 'odd') . '">' .
	'<div class="tradehistory_date">' . date('d') . ' ' . date('M') . '</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198073313540">๖ۣۜAmir ツ™</a>.							<span class="tradehistory_timestamp">' . date('g') . date('a') . '</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade1_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/jwasXcGSyvTZDEN-5e064TdKZuyF4sS0DcKQZAELckZGDZummI6M5nnVX4DDjWZvL009qIv9xLALyZd2ABVwTngShKuGn43cLcNjg8_QYHpxWCGv2ayIuwyWwDNKQDFGQQGI_o7Zx-IomAXdmZtlKjsIdv3ert_rDIiJa0g=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Battle-Worn Robot Money Furnace</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade1_givenitem0"><span class="history_item_name" style="color: #7D6D00;">The Bootlegger</span></span>, <span class="history_item" id="trade1_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Gloves of Running Urgently</span></span>, <span class="history_item" id="trade1_givenitem2"><span class="history_item_name" style="color: #7D6D00;">The Chargin\' Targe</span></span>, <span class="history_item" id="trade1_givenitem3"><span class="history_item_name" style="color: #7D6D00;">Mad Milk</span></span>							</div>' .
	'</div></div>';

}

function faker_header() {

	echo
	'<!DOCTYPE html>' .
	'<html>' .
	'<head>' .
	'<title>Steam Community :: ' . $_SESSION['currentUserName'] . ' :: Inventory History</title>' .
	'<link href="http://cdn.steamcommunity.com/public/shared/css/buttons.css?v=4243361609" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/shared/css/shared_global.css?v=4039944790" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/css/globalv2.css?v=881845923" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/css/skin_1/profilev2.css?v=2597020919" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/css/skin_1/economy.css?v=3559444065" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/css/skin_1/economy_inventory.css?v=55632743" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/css/skin_1/economy_history.css?v=2586289644" rel="stylesheet" type="text/css" >' .
	'<link href="http://cdn.steamcommunity.com/public/css/skin_1/header.css?v=1568802182" rel="stylesheet" type="text/css" >' .
	'<script  src="http://cdn.steamcommunity.com/public/javascript/prototype-1.7.js?v=3322715240&amp;l=english"></script>' .
	'<script  src="http://cdn.steamcommunity.com/public/javascript/scriptaculous/scriptaculous.js?load=effects,controls,slider,dragdrop&amp;v=2751892671&amp;l=english"></script>' .
	'<script  src="http://cdn.steamcommunity.com/public/javascript/global.js?v=4126859332&amp;l=english"></script>' .
	'<script  src="http://cdn.steamcommunity.com/public/javascript/jquery-1.8.3.min.js?v=138226611&amp;l=english"></script>' .
	'<script  src="http://cdn.steamcommunity.com/public/shared/javascript/tooltip.js?v=1941223714&amp;l=english"></script>' .
	'<script  src="http://cdn.steamcommunity.com/public/shared/javascript/shared_global.js?v=3306018184&amp;l=english"></script>' .
	'</head>' .
	'<body class="flat_page migrated_profile_page">' .
	'<!-- header bar, contains info browsing user if logged in -->' .
	'<div id="global_header">' .
	'<div class="content">' .
	'<div class="logo">' .
	'<span id="logo_holder">' .
	'<a href="http://store.steampowered.com/">' .
	'<img src="http://cdn.steamcommunity.com/public/images/header/globalheader_logo.png" width="176" height="44" border="0" alt="Steam Logo" />' .
	'</a>' .
	'</span>' .
	'<!--[if lt IE 7]>' .
	'<style type="text/css">' .
	'#logo_holder img { filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0); }' .
	'#logo_holder { display: inline-block; width: 176px; height: 44px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'http://cdn.steamcommunity.com/public/images/header/globalheader_logo.png\'); }' .
	'</style>' .
	'<![endif]-->' .
	//navbar
	'</div><div style="position: absolute; left: 200px;" id="supernav"><a class="menuitem supernav" href="http://store.steampowered.com/" data-tooltip-content="<a class=&quot;submenuitem&quot; href=&quot;http://store.steampowered.com/&quot;>Featured</a><a class=&quot;submenuitem&quot; href=&quot;http://store.steampowered.com/news/&quot;>News</a><a class=&quot;submenuitem&quot; href=&quot;http://store.steampowered.com/recommended/&quot;>Recommended</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/my/wishlist/&quot;>Wishlist</a><a class=&quot;submenuitem&quot; href=&quot;http://store.steampowered.com/stats/&quot;>STATS</a>">STORE	</a> <a class="menuitem supernav" style="display: block" href="http://steamcommunity.com/" data-tooltip-content="<a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/&quot;>Home</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/discussions/&quot;>DISCUSSIONS</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/workshop/&quot;>Workshop</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/greenlight/&quot;>Greenlight</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/market/&quot;>Market</a>">Community	</a><a class="menuitem supernav username" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/home/" data-tooltip-content="<a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/home/&quot;>Activity</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/&quot;>Profile</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/friends/&quot;>Friends</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/groups/&quot;>Groups</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/screenshots/&quot;>Content</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/badges/&quot;>Badges</a><a class=&quot;submenuitem&quot; href=&quot;http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/&quot;>Inventory</a>">' .
	'' . $_SESSION['currentUserName'] . '		</a>' .
	'<a class="menuitem" href="http://store.steampowered.com/about/">' .
	'ABOUT	</a>' .
	'<a class="menuitem" href="http://support.steampowered.com/">' .
	'SUPPORT	</a>' .
	'</div>' .
	'<script >' .
	'jQuery(document).ready(function($) { ' .
	'$(\'.tooltip\').tooltip();' .
	'$(\'.supernav\').tooltip({\'location\':\'bottom\', \'tooltipClass\': \'supernav_content\', \'offsetY\':-4, \'offsetX\': 1, \'horizontalSnap\': 4, \'tooltipParent\': \'#supernav\', \'correctForScreenSize\': false});' .
	'});' .
	'</script>		<div id="global_actions">' .
	'<div class="user_avatar">' .
	'<div class="playerAvatar online">' .
	'<a href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '"><img id="headerUserAvatarIcon" src="http://media.steampowered.com/steamcommunity/public/images/avatars/f2/f2c2877dffd78dc810728425e5ca98da88a8a620.jpg" alt=""></a>' .
	'</div>' .
	'</div>' .
	'<div id="global_action_menu">' .
	'<div class="header_installsteam_btn header_installsteam_btn_gray">' .
	'<div class="header_installsteam_btn_leftcap"></div>' .
	'<div class="header_installsteam_btn_rightcap"></div>' .
	'<a class="header_installsteam_btn_content" href="http://store.steampowered.com/about/">' .
	'Install Steam					</a>' .
	'</div>' .
	'<!-- notification inbox area -->' .
	'<div id="header_notification_area">' .
	'<div id="header_notification_link" class="header_notification_btn header_notification_empty" onclick="ShowMenu( this, \'header_notification_dropdown\', \'right\' );">' .
	'</div>' .
	'<div class="popup_block_new" id="header_notification_dropdown" style="display: none;">' .
	'<div class="popup_body popup_menu">' .
	'<a class="popup_menu_item header_notification_comments " href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/commentnotifications/">' .
	'<span class="notification_icon"></span>0 new comments			</a>' .
	'<div class="header_notification_dropdown_seperator"></div>' .
	'<a class="popup_menu_item header_notification_items " href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/">' .
	'<span class="notification_icon"></span>0 new items in your inventory			</a>' .
	'<div class="header_notification_dropdown_seperator"></div>' .
	'<a class="popup_menu_item header_notification_invites " href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/home/invites/">' .
	'<span class="notification_icon"></span>0 new invites			</a>' .
	'<div class="header_notification_dropdown_seperator"></div>' .
	'<a class="popup_menu_item header_notification_gifts " href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#pending_gifts">' .
	'<span class="notification_icon"></span>0 new gifts			</a>' .
	'<div class="header_notification_dropdown_seperator"></div>' .
	'<a class="popup_menu_item header_notification_offlinemessages " href="#" onclick="LaunchWebChat(); HideMenu( \'header_notification_link\', \'header_notification_dropdown\' ); ">' .
	'<span class="notification_icon"></span>0 unread chat messages			</a>' .
	'</div>' .
	'</div>' .
	'</div>' .
	'<span class="pulldown global_action_link" id="account_pulldown" onclick="ShowMenu( this, \'account_dropdown\', \'right\' );">01271\'s account</span>' .
	'<div class="popup_block" id="account_dropdown" style="display: none;">' .
	'<div class="shadow_ul"></div><div class="shadow_top"></div><div class="shadow_ur"></div><div class="shadow_left"></div><div class="shadow_right"></div><div class="shadow_bl"></div><div class="shadow_bottom"></div><div class="shadow_br"></div>						<div class="popup_body popup_menu shadow_content">' .
	'<a class="popup_menu_item" href="https://steamcommunity.com/login/logout">LogOut</a>' .
	'<a class="popup_menu_item" href="http://store.steampowered.com/account/">Account details</a>' .
	'<span class="popup_menu_item" id="account_language_pulldown">Change language</span>' .
	'<div class="popup_block" id="language_dropdown" style="display: none;">' .
	'<div class="shadow_ul"></div><div class="shadow_top"></div><div class="shadow_ur"></div><div class="shadow_left"></div><div class="shadow_right"></div><div class="shadow_bl"></div><div class="shadow_bottom"></div><div class="shadow_br"></div>								<div class="popup_body popup_menu shadow_content">' .
	'<a class="popup_menu_item tight" href="?l=bulgarian">Български (Bulgarian)</a>' .
	'<a class="popup_menu_item tight" href="?l=czech">čeština (Czech)</a>' .
	'<a class="popup_menu_item tight" href="?l=danish">Dansk (Danish)</a>' .
	'<a class="popup_menu_item tight" href="?l=dutch">Nederlands (Dutch)</a>' .
	'<a class="popup_menu_item tight" href="?l=finnish">Suomi (Finnish)</a>' .
	'<a class="popup_menu_item tight" href="?l=french">Français (French)</a>' .
	'<a class="popup_menu_item tight" href="?l=german">Deutsch (German)</a>' .
	'<a class="popup_menu_item tight" href="?l=greek">Ελληνικά (Greek)</a>' .
	'<a class="popup_menu_item tight" href="?l=hungarian">Magyar (Hungarian)</a>' .
	'<a class="popup_menu_item tight" href="?l=italian">Italiano (Italian)</a>' .
	'<a class="popup_menu_item tight" href="?l=japanese">日本語 (Japanese)</a>' .
	'<a class="popup_menu_item tight" href="?l=koreana">한국어 (Korean)</a>' .
	'<a class="popup_menu_item tight" href="?l=norwegian">Norsk (Norwegian)</a>' .
	'<a class="popup_menu_item tight" href="?l=polish">Polski (Polish)</a>' .
	'<a class="popup_menu_item tight" href="?l=portuguese">Português (Portuguese)</a>' .
	'<a class="popup_menu_item tight" href="?l=brazilian">Português-Brasil (Portuguese-Brazil)</a>' .
	'<a class="popup_menu_item tight" href="?l=romanian">Română (Romanian)</a>' .
	'<a class="popup_menu_item tight" href="?l=russian">Русский (Russian)</a>' .
	'<a class="popup_menu_item tight" href="?l=schinese">简体中文 (Simplified Chinese)</a>' .
	'<a class="popup_menu_item tight" href="?l=spanish">Español (Spanish)</a>' .
	'<a class="popup_menu_item tight" href="?l=swedish">Svenska (Swedish)</a>' .
	'<a class="popup_menu_item tight" href="?l=tchinese">繁體中文 (Traditional Chinese)</a>' .
	'<a class="popup_menu_item tight" href="?l=thai">ไทย (Thai)</a>' .
	'<a class="popup_menu_item tight" href="?l=turkish">Türkçe (Turkish)</a>' .
	'<a class="popup_menu_item tight" href="?l=ukrainian">Українська (Ukrainian)</a>' .
	'<a class="popup_menu_item tight" href="http://translation.steampowered.com" target=blank>Help us translate Steam</a>' .
	'</div>' .
	'</div>' .
	'<a class="popup_menu_item" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '">View profile</a>' .
	'</div>' .
	'</div>' .
	'<script >' .
	'$J( function() { RegisterFlyout( \'account_language_pulldown\', \'language_dropdown\', \'leftsubmenu\', \'bottomsubmenu\' ); } );' .
	'</script>' .
	'</div>' .
	'</div>' .
	'</div>' .
	'</div>' .
	'<div id="modalBG" style="display: none"></div>' .
	'<script >' .
	'g_sessionID = "MTg2MjE4NDIyNA==";' .
	'g_steamID = "76561198013370444";' .
	'$J( InitMiniprofileHovers );' .
	'$J( InitEmoticonHovers );' .
	'$J( function() {' .
	'window.BindCommunityTooltip = function( $Selector ) { $Selector.tooltip( {\'tooltipClass\': \'community_tooltip\', \'dataName\': \'communityTooltip\' } ); };' .
	'BindCommunityTooltip( $J(\'[data-community-tooltip]\') );' .
	'})' .
	'$J( function() { InitEconomyHovers( "<link href=\"http:\/\/cdn.steamcommunity.com\/public\/css\/skin_1\/economy.css?v=3559444065\" rel=\"stylesheet\" type=\"text\/css\" >\n", "<script type=\"text\/javascript\" src=\"http:\/\/cdn.steamcommunity.com\/public\/javascript\/economy.js?v=2406760210&amp;l=english\"><\/script>\n" );});</script><!-- /header bar -->' .
	'<div class="pagecontent no_header">' .
	'<!-- top content -->' .
	'<div class="profile_small_header_bg">' .
	'<div class="profile_small_header_texture">' .
	'<a href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '">' .
	'<div class="profile_small_header_avatar">' .
	'<div class="playerAvatar medium online">' .
	'<img src="http://media.steampowered.com/steamcommunity/public/images/avatars/f2/f2c2877dffd78dc810728425e5ca98da88a8a620_medium.jpg">' .
	'</div>' .
	'</div>' .
	'</a>' .
	'<div class="profile_small_header_text">' .
	'<span class="profile_small_header_name"><a class="whiteLink" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '">Digits</a></span>' .
	'<span class="profile_small_header_arrow">&raquo;</span>' .
	'<a class="whiteLink"  href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/"><span class="profile_small_header_location">Item Inventory</span></a>' .
	'<span class="profile_small_header_arrow">&raquo;</span>' .
	'<a class="whiteLink"  href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/history/"><span class="profile_small_header_location">Inventory History</span></a>' .
	'</div>' .
	'</div>' .
	'</div>	<!-- /top content -->' .
	'<!-- main body -->' .
	'<div id="BG_bottom" class="maincontent">' .
	'<div id="mainContents">' .
	'<div class="inventory_history_pagingrow">' .
	'<div class="inventory_history_nextbtn">' .
	'<span class="pagebtn disabled">&lt;</span>&nbsp;1&nbsp;&nbsp;<a class="pagelink" href="?p=2">2</a>&nbsp;&nbsp;<a class="pagelink" href="?p=3">3</a>&nbsp;...&nbsp;<a class="pagelink" href="?p=53">53</a>&nbsp;<a class=\'pagebtn\' href="?p=2">&gt;</a>				</div>' .
	'1 - 30 of 1573 History Items			</div>';

}

function faker_footer() {

	echo
	'<div class="inventory_history_pagingrow">' .
	'<div class="inventory_history_nextbtn">' .
	'<span class="pagebtn disabled">&lt;</span>&nbsp;1&nbsp;&nbsp;<a class="pagelink" href="?p=2">2</a>&nbsp;&nbsp;<a class="pagelink" href="?p=3">3</a>&nbsp;...&nbsp;<a class="pagelink" href="?p=53">53</a>&nbsp;<a class=\'pagebtn\' href="?p=2">&gt;</a>				</div>' .
	'1 - 30 of 1573 History Items			</div>' .
	'</div>' .
	'<div id="hover" style="display: none;">' .
	'<div class="shadow_ul"></div><div class="shadow_top"></div><div class="shadow_ur"></div><div class="shadow_left"></div><div class="shadow_right"></div><div class="shadow_bl"></div><div class="shadow_bottom"></div><div class="shadow_br"></div>			<div class="inventory_iteminfo hover_box shadow_content" id="iteminfo_clienthover">' .
	'<div class="item_desc_content" id="hover_content">' .
	'<div class="item_desc_icon">' .
	'<div class="item_desc_icon_center">' .
	'<img id="hover_item_icon">' .
	'</div>' .
	'</div>' .
	'<div class="item_desc_description">' .
	'<h1 class="hover_item_name" id="hover_item_name"></h1>' .
	'<div class="item_desc_game_info" id="hover_game_info">' .
	'<div class="item_desc_game_icon">' .
	'<img id="hover_game_icon">' .
	'</div>' .
	'<div id="hover_game_name" class="ellipsis"></div>' .
	'<div id="hover_item_type" class=""></div>' .
	'</div>' .
	'<div class="item_desc_descriptors" id="hover_item_descriptors">' .
	'</div>' .
	'<div class="item_desc_descriptors" id="hover_item_owner_descriptors">' .
	'</div>' .
	'</div>' .
	'</div>' .
	'</div>' .
	'<div class="hover_arrow_left" id="hover_arrow_left">' .
	'<div class="hover_arrow_inner"></div>' .
	'</div>' .
	'<div class="hover_arrow_right" id="hover_arrow_right">' .
	'<div class="hover_arrow_inner"></div>' .
	'</div>' .
	'</div>' .
	'<br clear="all" />' .
	'<br />' .
	'</div>' .
	'</div>' .
	'<div id="footer_spacer"></div>' .
	'<div id="footer">' .
	'<div class="footer_content">' .
	'<span id="footerLogo"><img src="http://cdn.steamcommunity.com/public/images/skin_1/footerLogo_valve.png" width="96" height="26" border="0" alt="Valve Logo" /></span>' .
	'<span id="footerText">' .
	'&copy; Valve Corporation. All rights reserved. All trademarks are property of their respective owners in the US and other countries.<br>Some geospatial data on this website is provided by <a href="https://steamcommunity.com/linkfilter/http://www.geonames.org" target=blank>geonames.org</a>.				<br>' .
	'<span class="valve_links">' .
	'<a href="http://store.steampowered.com/privacy_agreement/" target=blank>Privacy Policy</a> | <a href="http://www.valvesoftware.com/legal.htm" target=blank>Legal</a> | <a href="http://store.steampowered.com/subscriber_agreement/" target=blank>Steam Subscriber Agreement</a>' .
	'</span>' .
	'</span>' .
	'</div>' .
	'</div>' .
	'</body>' .
	'</html>';
}

function faker_createDemo() {
	echo

	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">21 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/konybatman">Batman</a>.							<span class="tradehistory_timestamp">8:39pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade0_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2613984907"><img src="http://cdn.steamcommunity.com/economy/image/_sbbWLdo2AAp0BMOuQ1Ri0aKEenzGNZA_R7AFF3rGSw3zeyj7nSeEokJD_CfbQ0FXo1Krf0H1kT7FccGXPsyLiTF8q39dIAWmEkP95cwMw1DnxbGpVaLSv1UnxdG-1x9NMSk-v8ijRKIRg6mxnNfQUifXPuqBZtPoUOeTRH-WSpik7K893Y=/120x40" style="border-color: #CF6A32;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #CF6A32;">Strange Festive Grenade Launcher</span></a>, <a class="history_item" id="trade0_receiveditem1" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2613984910"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">21 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198073313540">๖ۣۜAmir ツ™</a>.							<span class="tradehistory_timestamp">8:37pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade1_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/jwasXcGSyvTZDEN-5e064TdKZuyF4sS0DcKQZAELckZGDZummI6M5nnVX4DDjWZvL009qIv9xLALyZd2ABVwTngShKuGn43cLcNjg8_QYHpxWCGv2ayIuwyWwDNKQDFGQQGI_o7Zx-IomAXdmZtlKjsIdv3ert_rDIiJa0g=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Battle-Worn Robot Money Furnace</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade1_givenitem0"><span class="history_item_name" style="color: #7D6D00;">The Bootlegger</span></span>, <span class="history_item" id="trade1_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Gloves of Running Urgently</span></span>, <span class="history_item" id="trade1_givenitem2"><span class="history_item_name" style="color: #7D6D00;">The Chargin\' Targe</span></span>, <span class="history_item" id="trade1_givenitem3"><span class="history_item_name" style="color: #7D6D00;">Mad Milk</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">21 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/VerzD">Neil McCauley</a>.							<span class="tradehistory_timestamp">6:07pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade2_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Key</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">21 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/VerzD">Neil McCauley</a>.							<span class="tradehistory_timestamp">6:06pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade3_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/CbtDHr-sZ9YqUcyYnND8OLH3ia_73GmW_p8fgng2tJ_AsHTl5rAhxIqI0Ga6sKC2qfDS6_XDaZL4lBiQeS6lg_6xZfj2sH2V2pXWO-Kro6C9tJ7pp8Zyn_7LTtdkJPHOxbs36aO0Mpbcw4tr4fnx6Kntmg==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Key</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">20 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/freez1e">FreeZie hc™</a>.							<span class="tradehistory_timestamp">9:27pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade4_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/il-_YDEaOBS3MchkkWyT_jITddF1ajZKcv4TcjiWwlFXV5GAZk1vDB7p0pa1TcFtI0h1x31qJkln8hxrZpuXDxoKmtJvAmUNB_SKwOIbm2FoQXHAJittWmf1Ty59mN9MS13FwCtTKgoeoYqcuUzAc3UTZMAiNXhQaO8tczqLyFkMCpzML1s-WkDz0ZPjFc8yalM4mSwkKlhlokF6P8yfWBFazsIuUzoBQejHm70=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Team Spirit</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade4_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>, <span class="history_item" id="trade4_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>, <span class="history_item" id="trade4_givenitem2"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Key</span></span>, <span class="history_item" id="trade4_givenitem3"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">20 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198051329963">[Bazaar.tf] T-800</a>.							<span class="tradehistory_timestamp">9:06pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade5_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2612011127"><img src="http://cdn.steamcommunity.com/economy/image/iHhCBHQYEpoV4HSehQsz8DA0iLUwaBzawS6nhGHte1dBc3X_LQRUiLU5aGCja29-KDPT8T53HN7HJaCWYP1QWEF5Wvw7E0GI_yEzO6ggbGo-cMimayUD1pF--9cs-jgCFSgzozkDFduwLjJs93Zra2tujKtt/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Jag</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade5_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Scrap Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">20 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/benn94">beNN</a>.							<span class="tradehistory_timestamp">7:04pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade6_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2611871099"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>, <a class="history_item" id="trade6_receiveditem1" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2611871102"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">18 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/ethans9999">Buying All Fortified Compounds</a>.							<span class="tradehistory_timestamp">4:13pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade7_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2607535592"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>, <a class="history_item" id="trade7_receiveditem1" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2607535596"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">17 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/vbuaiu">Curly Brace</a>.							<span class="tradehistory_timestamp">1:50am</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade8_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2602337050"><img src="http://cdn.steamcommunity.com/economy/image/xNgw0THLdGIHRR09L-vMiXyU-mB1u3oi04vOJ8sNhC4N0wcqaNcycKecAcMJi5AHZJOhJHukeibVgMk1yh-HLh_hHSBrwiF2qO0OzRbDlFl10LwjeaBnKoKMknOGHcR9XYlPdyiHeSD1h1WaVcWSR3KFuSUspTcqmJ_JIQ==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Russian Rocketeer</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade8_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>, <span class="history_item" id="trade8_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Reclaimed Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">16 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/coooooooo01">℃o01⑨uy</a>.							<span class="tradehistory_timestamp">6:24pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade9_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem2"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem3"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem4"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem5"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem6"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem7"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem8"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem9"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem10"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem11"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem12"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade9_givenitem13"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">16 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/3p6">420 J</a>.							<span class="tradehistory_timestamp">5:53pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade10_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2601344939"><img src="http://cdn.steamcommunity.com/economy/image/NvV2q_unnKzfAyVWrLNcVo65vBq_15LyGsz-QAVJDfnr_VhLrPDLtHbbP6SIkg7Fn-K8DLfXgvEPwPFZWxVS9_qgAxmlv8G1b8Zn9NWfBZvU66ka9ZHZvFqdrwsPSwep9_BeUabxzL52mwWljpAN94qsug3g1t7kWc-pTF4SWK3_pgIM5rib7izMafbTzFjJ1f_wCbDPjONXm60dBURO5PD0/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>, <a class="history_item" id="trade10_receiveditem1" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2601344950"><img src="http://cdn.steamcommunity.com/economy/image/bH7Ed3ZqFStbJmFYjGJCj9QyDsYyGht1num6TiWYEyCxduqXIT1CM_L-e6qoQxAcxWkO0DoaC3aL5bVXe5EYe_16t8Uockgy6-Mjr6EbRhOIYBvGeFxQO9646wUvmhlwrXvsjSs8RTnyvkGrrkETLtAnCNFtG1dj3ertQn7DRnSlLbDQa3USaajpLfjzHUYQj3RC1T0CBWTTvukTJZVQPap_/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">13 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/fuckimlonely">21^Mikey \'ringme</a>.							<span class="tradehistory_timestamp">9:02pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade11_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2594448494"><img src="http://cdn.steamcommunity.com/economy/image/WC4iHwArClTeFM0XLGHqkeBi6K5EWwQUCtoeDciHojaRJRXkWTdMRn7N0ekKAbYf-GWz6kpEBBAM0RkfyZG3IZI9AfhxPl9RfYacs18X7lfsc6-7TEYZSwuGElnRx7dqk3wDuBg3DRoj0NDlUR_iCrB0pfAOGkw=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Earbuds</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade11_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Key</span></span>, <span class="history_item" id="trade11_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Key</span></span>, <span class="history_item" id="trade11_givenitem2"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Key</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">11 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/crummygun">kill bo obby</a>.							<span class="tradehistory_timestamp">9:30pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade12_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2590175415"><img src="http://cdn.steamcommunity.com/economy/image/2iobDX_uPTnPS9ixH-PbdGJm0bw7njNnCoQDp7YZitsHIjXtKLlqIWaTwkM7wonncz3RqjOeI2QfiAy-6BPQ1Ed_Pr8h9mAgf46aRWPO07loNMS8cdh4KUrVUuy8G4CLGy8z9yK4bStm0_hCPcCK1WZz16tkn39xSYdUq-1C348TeW-qYvE6ezyElBFgnN_rOSCdrzSGLXZH01D6thTJxhwr/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>, <a class="history_item" id="trade12_receiveditem1" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2590175412"><img src="http://cdn.steamcommunity.com/economy/image/bH7Ed3ZqFStbJmFYjGJCj9QyDsYyGht1num6TiWYEyCxduqXIT1CM_L-e6qoQxAcxWkO0DoaC3aL5bVXe5EYe_16t8Uockgy6-Mjr6EbRhOIYBvGeFxQO9646wUvmhlwrXvsjSs8RTnyvkGrrkETLtAnCNFtG1dj3ertQn7DRnSlLbDQa3USaajpLfjzHUYQj3RC1T0CBWTTvukTJZVQPap_/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">9 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/oneobstacle">Glutes for Sloots</a>.							<span class="tradehistory_timestamp">8:10pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade13_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/Teo9s7oKUhy-QrqhGf-hjPWm9wL-elxcaoxpu_0Z6SuE4QpI4xYUDh6bpl8_n_0C7aGsRfdlXFhsh26p_A_-IYujDUL1AwkFJdakQzfDsxHvs_cXmzYcXGKdbrOnE8J_y-5LEKIRXggbg_UCZon4Qvzg5kWnYxcGPY1j7bdY-X-EtUwUphECW0ybtV41/120x40" style="border-color: #D2D2D2;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #D2D2D2;">Winter Offensive Weapon Case</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade13_givenitem0"><span class="history_item_name" style="color: #D2D2D2;">Tec-9 | VariCamo</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">8 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/runicalchemist">D\'Artagnan</a>.							<span class="tradehistory_timestamp">2:54pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade14_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2580174463"><img src="http://cdn.steamcommunity.com/economy/image/NRKjrIN2ElgyzHFdEPtX9I1eaR3HBhwG9wOqS7kBBlvoGo1M1CFFQJsUa6802gVnnAVpC88GDAXiD6VS5wpTVPgQ3B7dbk9BggkzqGPWD27dDHwdjUBXSLdS-wCzAwwL9BeLVt4gQkqbVFGuMtgGVYlLbwqYB1AQtAD9R-JaUw_8QdcLnmkVGsEDPf1vhFNr1hglDsgeAhe6VPkWuQxFRvMT/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>, <a class="history_item" id="trade14_receiveditem1" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2580174471"><img src="http://cdn.steamcommunity.com/economy/image/YHlRO-5aS-CRZRO30aDnuNg1m4qqKkW-VKrIoXhathe9cX_buQ0c-Di9CUX1gbUryW6bnKIqVb1Bpse4JgLpQ60rJImwQhb5IaBREajWv3KCZ46K4GwO8BT7mepyWLxHoXx5wbMMG_I4_TNE84O2GdwgnZ31KwmoF6mfrSMB40OpKiWc80VMomKqXxeu3-Mng3PXmaUyW68Z_Zv8eFf1CqZ4/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">7 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198060178155">morbidly obese fag and friends</a>.							<span class="tradehistory_timestamp">5:06am</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade15_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #76</span></span>, <span class="history_item" id="trade15_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #77</span></span>, <span class="history_item" id="trade15_givenitem2"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade15_givenitem3"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade15_givenitem4"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #16</span></span>, <span class="history_item" id="trade15_givenitem5"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #17</span></span>, <span class="history_item" id="trade15_givenitem6"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #17</span></span>, <span class="history_item" id="trade15_givenitem7"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #18</span></span>, <span class="history_item" id="trade15_givenitem8"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #18</span></span>, <span class="history_item" id="trade15_givenitem9"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #26</span></span>, <span class="history_item" id="trade15_givenitem10"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #27</span></span>, <span class="history_item" id="trade15_givenitem11"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #77</span></span>, <span class="history_item" id="trade15_givenitem12"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #77</span></span>, <span class="history_item" id="trade15_givenitem13"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade15_givenitem14"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #76</span></span>, <span class="history_item" id="trade15_givenitem15"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade15_givenitem16"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #76</span></span>, <span class="history_item" id="trade15_givenitem17"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade15_givenitem18"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Munition Series #83</span></span>, <span class="history_item" id="trade15_givenitem19"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Munition Series #83</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">6 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198051341690">[Bazaar.tf] Weebo</a>.							<span class="tradehistory_timestamp">5:49pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade16_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2576122029"><img src="http://cdn.steamcommunity.com/economy/image/8Js-5GMWcKDJYEsW_FluM0jX9FUnZn7gHa6YDBi_JpQ5kAkfOgo2smm5V-jaOTK9UNCvESl5fuQbpZ8eGa8NgSqSJgMgCBu7bOVT4pkka_sTwLdDLHE0vkypxQxS-2uXbMpNEStYfbRo8QDhgS83_xHCt0Z_ZyHjHw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Cleaner\'s Carbine</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade16_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Scrap Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">6 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/SL1">#SL</a>.							<span class="tradehistory_timestamp">8:04am</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade17_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2575145285"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></a>, <span class="history_item" id="trade17_receiveditem1"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">5 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198051329963">[Bazaar.tf] T-800</a>.							<span class="tradehistory_timestamp">9:25pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade18_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2574346806"><img src="http://cdn.steamcommunity.com/economy/image/sQujygbAwu4SI3mjtprVEwlHaXtCsMyuxu2quVJ8nbR4AJQxX9yE_LL6ZV2Q-omdEUAyP0yvzKrA5q2rU2y2onoEiTdc2ITGurV0VZj7idpUVXsySKrQoMe5oegYN43oKAzXZh7dlKrv5jdUmOSO3QIGfDhMps2zze4=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Shahanshah</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade18_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Scrap Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">5 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/timeforbed">passhun</a>.							<span class="tradehistory_timestamp">2:52pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade19_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#753_6_693198532"><img src="http://cdn.steamcommunity.com/economy/image/KKW-Nm8E3rmbVvEwo8VsZ5DpdIcrdND5T5giKkcjJMDhronNNhiYqzuP7c6FpSLtnfxtlH42kuFElT8yRiAlx-yqmo0oEIupOtKhyJzvPOrXrzLDJWPPu0_EfXlYY2TBtqWalSMei6w8lriQ3rhooJr-NZUhaJzxHJgvKl0xYpGuqYnF/120x40" style="" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #;">Shark Joe (Profile Background)</span></a>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/coooooooo01">℃o01⑨uy</a>.							<span class="tradehistory_timestamp">8:17pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade20_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem2"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem3"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem4"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem5"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem6"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem7"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade20_givenitem8"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/hiuok">♥♥Hailey♥♥ #GamerGirls&gt;</a>.							<span class="tradehistory_timestamp">7:08pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade21_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade21_receiveditem1"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/SKGNick">Lear</a>.							<span class="tradehistory_timestamp">6:16pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade22_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>, <span class="history_item" id="trade22_receiveditem1"><img src="http://cdn.steamcommunity.com/economy/image/aNjOOjX6WqgZHN2byMBsyNCUBItxilTozdIOgSwmJG-h0_nBbOYcurnFwWXuoDBGyJNfz3-VVOzL2QmTLTE1Z6_h68d37zGzvJnFb63sNAHe1hHDf51C5J2FVNNkZmU9-I24miu6D-zv08E_tL4zD4rSQJgpiwvrzw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Bill\'s Hat</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/acli04">[Bazaar.tf] R2-D2</a>.							<span class="tradehistory_timestamp">4:46pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade23_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2571667618"><img src="http://cdn.steamcommunity.com/economy/image/g34NfHXwEPJrZT60No6-7Tsyx80xgB6yv6vtrtJo9kpKdTqHLOxW4Mu8IkoQ7uJjIzWciT-fHra5oOq803jdTUpiK4kp1lfrxuIkVyKt4mE0I52KPp5U77iq5v6dLrEaSCp62z3vRbefqiMRHKSxIjYlhY87mwnq7v3g4Yx15Q==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Bazaar Bargain</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade23_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Scrap Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/thischarmingrock">coolrocks</a>.							<span class="tradehistory_timestamp">4:46pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade24_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/K07kmbpqCYYXVwH0ECPy1ZMCLij-GgfGw5nS7vTFunLiRdNi43ZPlLeOHQo2Q65biwV1bPAFB8LFktX89cane-Z3zGvLeUifuJMhCToeqE7VQD8-9gxLycOb37i8jv12sR-WNKwlCZfjkkYDalitTZkSOGzyBk6SwtPL4b0=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>, <span class="history_item" id="trade24_receiveditem1"><img src="http://cdn.steamcommunity.com/economy/image/K07kmbpqCYYXVwH0ECPy1ZMCLij-GgfGw5nS7vTFunLiRdNi43ZPlLeOHQo2Q65biwV1bPAFB8LFktX89cane-Z3zGvLeUifuJMhCToeqE7VQD8-9gxLycOb37i8jv12sR-WNKwlCZfjkkYDalitTZkSOGzyBk6SwtPL4b0=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>, <span class="history_item" id="trade24_receiveditem2"><img src="http://cdn.steamcommunity.com/economy/image/K07kmbpqCYYXVwH0ECPy1ZMCLij-GgfGw5nS7vTFunLiRdNi43ZPlLeOHQo2Q65biwV1bPAFB8LFktX89cane-Z3zGvLeUifuJMhCToeqE7VQD8-9gxLycOb37i8jv12sR-WNKwlCZfjkkYDalitTZkSOGzyBk6SwtPL4b0=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade24_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #21</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/filipinoninja">[RSPC] Sn❄w</a>.							<span class="tradehistory_timestamp">4:43pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade25_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2571662170"><img src="http://cdn.steamcommunity.com/economy/image/f44c0Dhh6B4-D9vDBM3sxcfC1mF8EeZe6sEI2eArpGK2hSsrYX2uDJ7Wxz0irbBL38WNJXIO5lrsyg_L4TWmaoiaNCZ_bK82ysv7Pi7wtl6BhMQjIlisArfAAI78OeU15d1tdCMr5QjMyZYxeLSwWJmPwXMkCfAAvYsR1qk=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Reinforced Robot Emotion Detector</span></a>, <span class="history_item" id="trade25_receiveditem1"><img src="http://cdn.steamcommunity.com/economy/image/f44c0Dhh6B4-D9vDBM3sxcfC1mF8EeZe6sEI2eArpGK2hSsrYX2uDJ7Wxz0irbBL38WNJXIO5lrsyg_L4TWmaoiaNCZ_bK82ysv7Pi7wtl6BhMQjIlisArfAAI78OeU15d1tdCMr5QjMyZYxeLSwWJmPwXMkCfAAvYsR1qk=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Reinforced Robot Emotion Detector</span></span>, <span class="history_item" id="trade25_receiveditem2"><img src="http://cdn.steamcommunity.com/economy/image/f44c0Dhh6B4-D9vDBM3sxcfC1mF8EeZe6sEI2eArpGK2hSsrYX2uDJ7Wxz0irbBL38WNJXIO5lrsyg_L4TWmaoiaNCZ_bK82ysv7Pi7wtl6BhMQjIlisArfAAI78OeU15d1tdCMr5QjMyZYxeLSwWJmPwXMkCfAAvYsR1qk=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Reinforced Robot Emotion Detector</span></span>, <span class="history_item" id="trade25_receiveditem3"><img src="http://cdn.steamcommunity.com/economy/image/f44c0Dhh6B4-D9vDBM3sxcfC1mF8EeZe6sEI2eArpGK2hSsrYX2uDJ7Wxz0irbBL38WNJXIO5lrsyg_L4TWmaoiaNCZ_bK82ysv7Pi7wtl6BhMQjIlisArfAAI78OeU15d1tdCMr5QjMyZYxeLSwWJmPwXMkCfAAvYsR1qk=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Reinforced Robot Emotion Detector</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade25_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Refined Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">4 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198123638867">[RSPC] Chocolate Milk</a>.							<span class="tradehistory_timestamp">4:29pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<span class="history_item" id="trade26_receiveditem0"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #76</span></span>, <span class="history_item" id="trade26_receiveditem1"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #77</span></span>, <span class="history_item" id="trade26_receiveditem2"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade26_receiveditem3"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade26_receiveditem4"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #16</span></span>, <span class="history_item" id="trade26_receiveditem5"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #17</span></span>, <span class="history_item" id="trade26_receiveditem6"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #17</span></span>, <span class="history_item" id="trade26_receiveditem7"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #18</span></span>, <span class="history_item" id="trade26_receiveditem8"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #18</span></span>, <span class="history_item" id="trade26_receiveditem9"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #21</span></span>, <span class="history_item" id="trade26_receiveditem10"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #26</span></span>, <span class="history_item" id="trade26_receiveditem11"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #27</span></span>, <span class="history_item" id="trade26_receiveditem12"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #77</span></span>, <span class="history_item" id="trade26_receiveditem13"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #77</span></span>, <span class="history_item" id="trade26_receiveditem14"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade26_receiveditem15"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #76</span></span>, <span class="history_item" id="trade26_receiveditem16"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade26_receiveditem17"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #76</span></span>, <span class="history_item" id="trade26_receiveditem18"><img src="http://cdn.steamcommunity.com/economy/image/_VXnBMGwoi_KfT5lXRuJn0UZLbWFwKxvHrPtf7n9wTg0XtD_mKzkPWqkIpt7e9URXR528YvfrGsYuOptuO3HPCFW__yOu_E9IOgnki4211AbVT-n3om3Nx_u5yvx6o07YQuW9Iysrmtv6HmSJ2LXABVDKavY/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Crate Series #75</span></span>, <span class="history_item" id="trade26_receiveditem19"><img src="http://cdn.steamcommunity.com/economy/image/pFDE9MVk1swNoXjgy6x4uRwcDkWBFNiM2W-r-i9KMB5tW_MPnHiQ3q14ZB7tzCQ3BBtVAY8L2IjfZKzoLlo2GnhT3BaKb4vavT9oH9-PJDUTDVQDiAPFg907oahnDXZPOwC1VNor1tj6M2FH4tIhdkNdG1CPCcLT2jOhtXFXIw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Munition Series #83</span></span>, <span class="history_item" id="trade26_receiveditem20"><img src="http://cdn.steamcommunity.com/economy/image/pFDE9MVk1swNoXjgy6x4uRwcDkWBFNiM2W-r-i9KMB5tW_MPnHiQ3q14ZB7tzCQ3BBtVAY8L2IjfZKzoLlo2GnhT3BaKb4vavT9oH9-PJDUTDVQDiAPFg907oahnDXZPOwC1VNor1tj6M2FH4tIhdkNdG1CPCcLT2jOhtXFXIw==/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">Mann Co. Supply Munition Series #83</span></span>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade26_givenitem0"><span class="history_item_name" style="color: #7D6D00;">The Bazaar Bargain</span></span>, <span class="history_item" id="trade26_givenitem1"><span class="history_item_name" style="color: #7D6D00;">The Cleaner\'s Carbine</span></span>, <span class="history_item" id="trade26_givenitem2"><span class="history_item_name" style="color: #CF6A32;">Strange Wrap Assassin</span></span>, <span class="history_item" id="trade26_givenitem3"><span class="history_item_name" style="color: #7D6D00;">The Shahanshah</span></span>, <span class="history_item" id="trade26_givenitem4"><span class="history_item_name" style="color: #7D6D00;">The Splendid Screen</span></span>, <span class="history_item" id="trade26_givenitem5"><span class="history_item_name" style="color: #CF6A32;">Strange Kukri</span></span>, <span class="history_item" id="trade26_givenitem6"><span class="history_item_name" style="color: #7D6D00;">The Battalion\'s Backup</span></span>, <span class="history_item" id="trade26_givenitem7"><span class="history_item_name" style="color: #7D6D00;">The Boston Basher</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">2 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/id/bazaartf2">[Bazaar.tf] Grounder</a>.							<span class="tradehistory_timestamp">4:48pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade27_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2565630229"><img src="http://cdn.steamcommunity.com/economy/image/X6R_r1GGDB6a4cDMjB1By-fotR4V9gJeTi8T1mj7CWyWr0hUCJpKDDo43DKqfR1F_-_uWhvpAlpIJBTEaesiepOdVl4QkUsAOXjgMaYgG1ChqqRfF-8bURl8Qoclvk5sw_YKA0uZWl9rJttl92ZIUe3-9F8dukkAHmUK2SE=/120x40" style="border-color: #4D7455;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #4D7455;">Genuine Neon Annihilator</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade27_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Reclaimed Metal</span></span>, <span class="history_item" id="trade27_givenitem1"><span class="history_item_name" style="color: #7D6D00;">Reclaimed Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow even">' .
	'<div class="tradehistory_date">2 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198051329437">[Bazaar.tf] Atlas</a>.							<span class="tradehistory_timestamp">4:45pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade28_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2565624383"><img src="http://cdn.steamcommunity.com/economy/image/wL0uNyJoMTkK_K3CtDzPgnjx5IZmGD953jJ-2FDahyUJthnMe3R3K6olsTySXJMMYPa_wmgHP33YOXnKUcqsIh29D9Ntcm4RomqgNJpdy0VytfPEb1F0cY4wJo8Yz5J3WL0Pwj4iPH35PuZjnkSQGibm9JVqAj5k1TE=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Buff Banner</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade28_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Scrap Metal</span></span>							</div>' .
	'</div>' .
	'</div>' .
	'<div class="tradehistoryrow odd">' .
	'<div class="tradehistory_date">2 May</div>' .
	'<div class="tradehistory_content">' .
	'<div class="tradehistory_event_description">' .
	'You traded with <a href="http://steamcommunity.com/profiles/76561198051329339">[Bazaar.tf] R.O.B.</a>.							<span class="tradehistory_timestamp">4:45pm</span>' .
	'</div>' .
	'<div class="tradehistory_items tradehistory_items_received">' .
	'<div class="tradehistory_items_plusminus">+</div>' .
	'<a class="history_item" id="trade29_receiveditem0" href="http://steamcommunity.com/profiles/' . $_SESSION['sid'] . '/inventory/#440_2_2565623257"><img src="http://cdn.steamcommunity.com/economy/image/9D389x0-3CPxlixEx7uZbUxxNkZZTtJjJVj_XiNd0co9NssMRCKaMVFPMLrh28XjVHZtAldR0mcjU_hMIk36zTA62AhRKJALWQAhsunax6tCPXBUW1mYP3MOpQdvTMfNPW7eWgB-jm0BVzCx6cDGphNgdAdUA9N-Lls=/120x40" style="border-color: #7D6D00;background-color: #3C352E;" class="tradehistory_received_item_img"><span class="history_item_name" style="color: #7D6D00;">The Black Box</span></a>							</div>' .
	'<div class="tradehistory_items tradehistory_items_given">' .
	'<div class="tradehistory_items_plusminus">&ndash;</div>' .
	'<span class="history_item" id="trade29_givenitem0"><span class="history_item_name" style="color: #7D6D00;">Scrap Metal</span></span>							</div>' .
	'</div>' .
	'</div>';
}